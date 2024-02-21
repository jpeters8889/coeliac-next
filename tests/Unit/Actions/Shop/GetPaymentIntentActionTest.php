<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Shop\GetPaymentIntentAction;
use Stripe\PaymentIntent;
use Stripe\Service\MocksStripe;
use Tests\TestCase;

class GetPaymentIntentActionTest extends TestCase
{
    use MocksStripe;

    /** @test */
    public function itCanGetAPaymentIntent(): void
    {
        $this->mockRetrievePaymentIntent('foo');

        $result = $this->callAction(GetPaymentIntentAction::class, 'foo');

        $this->assertInstanceOf(PaymentIntent::class, $result);
        $this->assertEquals('foo', $result->client_secret);
    }
}
