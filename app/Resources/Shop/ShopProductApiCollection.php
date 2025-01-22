<?php

declare(strict_types=1);

namespace App\Resources\Shop;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopProductApiCollection extends ResourceCollection
{
    public $collects = ShopProductApiResource::class;
}
