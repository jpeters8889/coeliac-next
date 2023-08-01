<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\EateryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EateryTown */
class CountyTownResource extends JsonResource
{
    /** @return array{name: string, link: string, eateries: int, attractions: int, hotels: int} */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->town,
            'link' => $this->link(),
            'eateries' => $this->eateries->where('type_id', EateryType::EATERY)->count(),
            'attractions' => $this->eateries->where('type_id', EateryType::ATTRACTION)->count(),
            'hotels' => $this->eateries->where('type_id', EateryType::HOTEL)->count(),
        ];
    }
}
