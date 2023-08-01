<?php

declare(strict_types=1);

namespace App\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectedItemCollection extends ResourceCollection
{
    public $collects = CollectedItemResource::class;
}
