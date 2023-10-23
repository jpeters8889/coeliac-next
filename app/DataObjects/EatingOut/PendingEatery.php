<?php

declare(strict_types=1);

namespace App\DataObjects\EatingOut;

use Spatie\LaravelData\Data;

class PendingEatery extends Data
{
    public function __construct(
        public int $id,
        public ?int $branchId,
        public string $ordering,
        public ?float $distance = null,
    ) {
    }
}
