<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\Shop\ResolveBasketAction;
use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class ResolveBasketActionTest extends TestCase
{
    #[Test]
    public function itReturnsABasketShopOrderRecordIfOneExistsWithTheGivenToken(): void
    {
        /** @var ShopOrder $order */
        $order = $this->create(ShopOrder::class);
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $result = $this->callAction(ResolveBasketAction::class, $order->token);

        $this->assertDatabaseCount(ShopOrder::class, 1);
        $this->assertTrue($order->is($result));
    }

    #[Test]
    public function itDoesntReturnAnExistingBasketIfItHasExpired(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asExpired()->create();
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $this->callAction(ResolveBasketAction::class, $order->token);

        $this->assertDatabaseCount(ShopOrder::class, 2);
    }

    #[Test]
    public function itCreatesANewRecordIfATokenIsntPassed(): void
    {
        $this->assertDatabaseEmpty(ShopOrder::class);

        $this->callAction(ResolveBasketAction::class);

        $this->assertDatabaseCount(ShopOrder::class, 1);

        $order = ShopOrder::query()->first();
        $this->assertEquals(OrderState::BASKET, $order->state_id);
    }

    #[Test]
    public function itWillNotCreateABasketIfTheCreateFlagIsFalse(): void
    {
        $this->assertDatabaseEmpty(ShopOrder::class);

        $this->callAction(ResolveBasketAction::class, null, false);

        $this->assertDatabaseEmpty(ShopOrder::class);
    }
}
