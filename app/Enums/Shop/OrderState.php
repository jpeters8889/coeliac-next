<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum OrderState: int
{
    case BASKET = 1;
    case PAID = 2;
    case PRINTED = 3;
    case SHIPPED = 4;
    case COMPLETE = 5;
    case REFUNDED = 6;
    case CANCELLED = 7;
    case EXPIRED = 8;

    public function name(): string
    {
        return match ($this) {
            self::BASKET => 'Basket',
            self::PAID => 'Paid',
            self::PRINTED => 'Printed',
            self::SHIPPED => 'Shipped',
            self::COMPLETE => 'Complete',
            self::REFUNDED => 'Refunded',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }
}
