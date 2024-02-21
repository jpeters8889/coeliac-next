<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use Stripe\PaymentIntent;
use Stripe\StripeClient;

class GetPaymentIntentAction
{
    public function __construct(protected StripeClient $stripeClient)
    {
        //
    }

    public function handle(string $paymentIntentId): PaymentIntent
    {
        return $this->stripeClient
            ->paymentIntents
            ->retrieve($paymentIntentId);
    }
}
