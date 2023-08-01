<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EateryListCollection extends ResourceCollection
{
    public $collects = EateryListResource::class;
}
