<?php

declare(strict_types=1);

namespace App\DataObjects\EatingOut;

use Spatie\LaravelData\Data;

class LatLng extends Data
{
    public function __construct(public float $lat, public float $lng, public ?string $label = null)
    {
        //
    }

    public function toString(): string
    {
        return "{$this->lat},{$this->lng}";
    }
}
