<?php

declare(strict_types=1);

namespace App\DataObjects\EatingOut;

readonly class EateryStatistics
{
    public function __construct(
        public int $total,
        public int $eateries,
        public int $attractions,
        public int $hotels,
        public int $reviews,
    ) {
        //
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
