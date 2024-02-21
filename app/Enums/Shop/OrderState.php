<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum OrderState: int
{
    case BASKET = 1;
    case PENDING = 2;
    case PAID = 3;
    case SHIPPED = 4;
    case COMPLETE = 5;
    case REFUNDED = 6;
    case CANCELLED = 7;
    case EXPIRED = 8;

    public function name(): string
    {
        return match ($this) {
            self::BASKET => 'Basket',
            self::PENDING => 'Pending',
            self::PAID => 'Paid',
            self::SHIPPED => 'Shipped',
            self::COMPLETE => 'Complete',
            self::REFUNDED => 'Refunded',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }
}
