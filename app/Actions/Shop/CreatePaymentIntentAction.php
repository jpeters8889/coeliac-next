<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Models\Shop\ShopOrder;
use Stripe\StripeClient;

class CreatePaymentIntentAction
{
    public function __construct(protected StripeClient $stripeClient)
    {
        //
    }

    public function handle(ShopOrder $order, int $amount): string
    {
        if ($order->payment_intent_id && $order->payment_intent_secret) {
            $this->stripeClient->paymentIntents->update($order->payment_intent_id, [
                'amount' => $amount,
            ]);

            return $order->payment_intent_secret;
        }

        $intent = $this->stripeClient->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'gbp',
            'payment_method_types' => ['card', 'paypal'],
        ]);

        $order->update([
            'payment_intent_id' => $intent->id,
            'payment_intent_secret' => $intent->client_secret,
        ]);

        return (string) $intent->client_secret;
    }
}
