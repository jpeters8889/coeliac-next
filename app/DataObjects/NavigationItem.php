<?php

declare(strict_types=1);

namespace App\DataObjects;

class NavigationItem
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
