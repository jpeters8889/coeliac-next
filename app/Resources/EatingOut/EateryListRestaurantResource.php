<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\EateryAttractionRestaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EateryAttractionRestaurant */
class EateryListRestaurantResource extends JsonResource
{
    /** @return array{name: string, info: string} */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->restaurant_name,
            'info' => $this->info,
        ];
    }
}
