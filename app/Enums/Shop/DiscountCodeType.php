<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum DiscountCodeType: int
{
    case PERCENTAGE = 1;
    case MONEY = 2;

    public function name(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'Percentage',
            self::MONEY => 'Money',
        };
    }
}
