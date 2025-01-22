<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Shop\Products;

use App\Models\Shop\ShopProduct;
use App\Resources\Shop\ShopProductApiResource;

class GetController
{
    public function __invoke(ShopProduct $product): ShopProductApiResource
    {
        return ShopProductApiResource::make($product);
    }
}
