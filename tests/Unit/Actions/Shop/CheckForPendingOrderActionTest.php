<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\Shop\CheckForPendingOrderAction;
use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class CheckForPendingOrderActionTest extends TestCase
{
    #[Test]
    public function itReturnsAPendingOrderRecordIfOneExistsWithTheGivenToken(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPending()->create();
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $result = $this->callAction(CheckForPendingOrderAction::class, $order->token);

        $this->assertDatabaseCount(ShopOrder::class, 1);
        $this->assertTrue($order->is($result));
    }

    #[Test]
    public function itUpdatesAPendingOrderToBasket(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPending()->create();
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $this->callAction(CheckForPendingOrderAction::class, $order->token);

        $this->assertEquals(OrderState::BASKET, $order->refresh()->state_id);
    }

    #[Test]
    public function itDoesntReturnAnOrderIfItIsNotPending(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPaid()->create();
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $result = $this->callAction(CheckForPendingOrderAction::class, $order->token);

        $this->assertNull($result);

        $this->assertDatabaseCount(ShopOrder::class, 1);
    }
}
