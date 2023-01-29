<?php

declare(strict_types=1);

namespace App\Modules\Shared\DataObjects;

use Spatie\LaravelData\Data;

class NavigationItem extends Data
{
    public function __construct(
        public string $title,
        public string $link,
        public string $description,
        public string $image,
    ) {
        //
    }
}
