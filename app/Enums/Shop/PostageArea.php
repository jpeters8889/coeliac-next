<?php

declare(strict_types=1);

namespace App\Enums\Shop;

enum PostageArea: int
{
    case UK = 1;
    case EUROPE = 2;
    case AMERICA = 3;
    case OCEANA = 4;

    public function name(): string
    {
        return match ($this) {
            self::UK => 'United Kingdom',
            self::EUROPE => 'Europe',
            self::AMERICA => 'North America',
            self::OCEANA => 'Oceana',
        };
    }

    public function deliveryEstimate(): string
    {
        return match ($this) {
            self::UK => '1 - 2',
            self::EUROPE => '5 - 7',
            self::AMERICA, self::OCEANA => '10 - 15',
        };
    }
}
