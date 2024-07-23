<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Shop\TravelCardSearch;

use App\Models\Shop\TravelCardSearchTerm;
use App\Resources\Shop\ShopProductIndexResource;
use Illuminate\Support\Str;

class GetController
{
    public function __invoke(TravelCardSearchTerm $travelCardSearchTerm): array
    {
        $travelCardSearchTerm->increment('hits');

        $products = $travelCardSearchTerm->products->load(['reviews', 'prices', 'variants']);

        return [
            'term' => Str::title($travelCardSearchTerm->term),
            'type' => $travelCardSearchTerm->type,
            'products' => ShopProductIndexResource::collection($products),
        ];
    }
}
