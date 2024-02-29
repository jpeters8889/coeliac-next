<?php

declare(strict_types=1);

namespace App\DataObjects;

final readonly class NotificationRelatedObject
{
    public function __construct(
        public string $title,
        public string $image,
        public string $link,
    ) {
        //
    }
}
