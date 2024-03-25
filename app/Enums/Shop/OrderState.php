<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum OrderState: int
{
    case BASKET = 1;
    case PENDING = 2;
    case PAID = 3;
    case READY = 4;
    case SHIPPED = 5;
    case REFUNDED = 6;
    case CANCELLED = 7;
    case EXPIRED = 8;

    public function name(): string
    {
        return match ($this) {
            self::BASKET => 'Basket',
            self::PENDING => 'Pending',
            self::PAID => 'Paid',
            self::READY => 'Ready',
            self::SHIPPED => 'Shipped',
            self::REFUNDED => 'Refunded',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }
}
