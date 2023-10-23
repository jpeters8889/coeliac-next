<?php

declare(strict_types=1);

namespace App\Support;

class Helpers
{
    public static function milesToMeters(float $miles): float
    {
        return round($miles * 1609.344);
    }
}
