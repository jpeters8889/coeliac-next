<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum ShippingMethod: int
{
    case SMALL_LETTER = 1;
    case LETTER = 2;
    case LARGE_LETTER = 3;
    case SMALL_PARCEL = 4;
    case PARCEL = 5;
    case LARGE_PARCEL = 6;

    public function name(): string
    {
        return match ($this) {
            self::SMALL_LETTER => 'small-letter',
            self::LETTER => 'letter',
            self::LARGE_LETTER => 'large-letter',
            self::SMALL_PARCEL => 'small-parcel',
            self::PARCEL => 'parcel',
            self::LARGE_PARCEL => 'large-parcel',
        };
    }
}
