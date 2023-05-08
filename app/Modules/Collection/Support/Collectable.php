<?php

declare(strict_types=1);

namespace App\Modules\Collection\Support;

interface Collectable
{
    /** @phpstan-return mixed */
    public function getKey();
}
