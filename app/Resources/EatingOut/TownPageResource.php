<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\EateryTown;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EateryTown */
class TownPageResource extends JsonResource
{
    /** @return array{name: string, slug: string, image: string, county: TownCountyResource} */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->town,
            'slug' => $this->slug,
            'image' => $this->image ?? $this->county->image ?? $this->county->country->image,
            'county' => new TownCountyResource($this->county),
        ];
    }
}
