<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Shop\CreatePaymentIntentAction;
use App\Models\Shop\ShopOrder;
use Tests\Concerns\MocksStripe;
use Tests\TestCase;

class CreatePaymentIntentActionTest extends TestCase
{
    use MocksStripe;

    /** @test */
    public function itStoresThePaymentIntentAgainstTheOrder(): void
    {
        /** @var ShopOrder $order */
        $order = $this->create(ShopOrder::class);
        $mockToken = $this->mockCreatePaymentIntent(3500);

        $this->assertNull($order->payment_intent_id);

        $this->callAction(CreatePaymentIntentAction::class, $order, 3500);

        $this->assertNotNull($order->payment_intent_id);
        $this->assertNotNull($order->payment_intent_secret);

        $this->assertEquals($mockToken, $order->payment_intent_secret);
    }

    /** @test */
    public function itReturnsTheClientSecret(): void
    {
        $order = $this->create(ShopOrder::class);
        $mockToken = $this->mockCreatePaymentIntent(3500);

        $returnedToken = $this->callAction(CreatePaymentIntentAction::class, $order, 3500);

        $this->assertEquals($mockToken, $returnedToken);
    }

    /** @test */
    public function itUpdatesThePaymentIntentIfTheOrderHasAPaymentId(): void
    {
        $order = $this->create(ShopOrder::class, [
            'payment_intent_id' => 'foo',
            'payment_intent_secret' => 'bar',
        ]);

        $this->mockUpdatePaymentIntent('foo');

        $this->callAction(CreatePaymentIntentAction::class, $order, 3500);
    }
}
