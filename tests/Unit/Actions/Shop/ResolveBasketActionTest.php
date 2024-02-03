<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Shop\ResolveBasketAction;
use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class ResolveBasketActionTest extends TestCase
{
    /** @test */
    public function itReturnsABasketShopOrderRecordIfOneExistsWithTheGivenToken(): void
    {
        /** @var ShopOrder $order */
        $order = $this->create(ShopOrder::class);
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $result = $this->callAction(ResolveBasketAction::class, $order->token);

        $this->assertDatabaseCount(ShopOrder::class, 1);
        $this->assertTrue($order->is($result));
    }

    /** @test */
    public function itDoesntReturnAnExistingBasketIfItHasExpired(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asExpired()->create();
        $this->assertDatabaseCount(ShopOrder::class, 1);

        $this->callAction(ResolveBasketAction::class, $order->token);

        $this->assertDatabaseCount(ShopOrder::class, 2);
    }

    /** @test */
    public function itCreatesANewRecordIfATokenIsntPassed(): void
    {
        $this->assertDatabaseEmpty(ShopOrder::class);

        $this->callAction(ResolveBasketAction::class);

        $this->assertDatabaseCount(ShopOrder::class, 1);

        $order = ShopOrder::query()->first();
        $this->assertEquals(OrderState::BASKET, $order->state_id);
    }

    /** @test */
    public function itWillNotCreateABasketIfTheCreateFlagIsFalse(): void
    {
        $this->assertDatabaseEmpty(ShopOrder::class);

        $this->callAction(ResolveBasketAction::class, null, false);

        $this->assertDatabaseEmpty(ShopOrder::class);
    }
}
