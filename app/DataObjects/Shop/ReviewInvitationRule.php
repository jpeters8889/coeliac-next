<?php

declare(strict_types=1);

namespace App\DataObjects\Shop;

use Carbon\CarbonInterface;

class ReviewInvitationRule
{
    public function __construct(
        public CarbonInterface $date,
        public array $areas,
        public string $text,
    ) {
        //
    }
}
