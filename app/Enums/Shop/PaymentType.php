<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum PaymentType: int
{
    case STRIPE = 1;
    case PAYPAL = 2;

    public function name(): string
    {
        return match ($this) {
            self::STRIPE => 'Stripe',
            self::PAYPAL => 'PayPal',
        };
    }
}
