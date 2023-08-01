<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\EateryCounty;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EateryCounty */
class TownCountyResource extends JsonResource
{
    /** @return array{name: string, link: string} */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->county,
            'link' => $this->link(),
        ];
    }
}
