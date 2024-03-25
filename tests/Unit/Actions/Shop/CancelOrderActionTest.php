<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Shop\CancelOrderAction;
use App\Enums\Shop\OrderState;
use App\Events\Shop\OrderCancelledEvent;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopProductVariant;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CancelOrderActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function itUpdatesTheOrderToCancelled(): void
    {
        $order = $this->build(ShopOrder::class)->asReady()->create();

        $this->assertEquals(OrderState::READY, $order->state_id);

        $this->callAction(CancelOrderAction::class, $order);

        $this->assertEquals(OrderState::CANCELLED, $order->fresh()->state_id);
    }

    /** @test */
    public function itPutsTheOrderItemsBackIntoStock(): void
    {
        $this->withCategoriesAndProducts(1, 1);

        $order = $this->build(ShopOrder::class)->asReady()->create();
        $variant = ShopProductVariant::query()->first();
        $existingQuantity = $variant->quantity;

        $this->build(ShopOrderItem::class)
            ->inOrder($order)
            ->add($variant, 5)
            ->create();

        $this->callAction(CancelOrderAction::class, $order);

        $this->assertEquals($existingQuantity + 5, $variant->fresh()->quantity);
    }

    /** @test */
    public function itDispatchesAnOrderCancelledEvent(): void
    {
        $order = $this->build(ShopOrder::class)->asReady()->create();

        $this->callAction(CancelOrderAction::class, $order);

        Event::assertDispatched(OrderCancelledEvent::class);
    }
}
