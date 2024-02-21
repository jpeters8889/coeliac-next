<?php

declare(strict_types=1);

namespace Feature\Http\Controllers\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class ShopRevertPendingOrderController extends TestCase
{
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = $this->build(ShopOrder::class)->asPending()->create();
    }

    /** @test */
    public function itReturnsNoContentEvenIfABasketDoesntExist(): void
    {
        $this->delete(route('shop.basket.revert'))->assertNoContent();
    }

    /** @test */
    public function itDoesntUpdateAnOrderThatIsntPending(): void
    {
        $this->order->update(['state_id' => OrderState::EXPIRED]);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->delete(route('shop.basket.revert'))
            ->assertNoContent();

        $this->assertEquals(OrderState::EXPIRED, $this->order->refresh()->state_id);
    }

    /** @test */
    public function itUpdatesAPendingOrderBackToBasket(): void
    {
        $this->assertEquals(OrderState::PENDING, $this->order->refresh()->state_id);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->delete(route('shop.basket.revert'))
            ->assertNoContent();

        $this->assertEquals(OrderState::BASKET, $this->order->refresh()->state_id);
    }
}
