<?php

declare(strict_types=1);

namespace App\DataObjects\EatingOut;

class RecommendAPlaceExistsCheckData
{
    public function __construct(
        readonly public ?string $name = null,
        readonly public ?string $location = null,
        public bool $found = false,
        public ?string $reason = null,
        public ?string $url = null,
        public ?string $label = null,
    ) {
        //
    }
}
