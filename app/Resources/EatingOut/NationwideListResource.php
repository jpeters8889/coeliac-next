<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\Eatery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Eatery */
class NationwideListResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'key' => $this->id,
            'link' => "/wheretoeat/nationwide/{$this->slug}",
            'venue_type' => $this->venueType->venue_type,
            'type' => $this->type->name,
            'cuisine' => $this->cuisine?->cuisine,
            'website' => $this->website,
            'info' => $this->info,
            'phone' => $this->phone,
            'reviews' => [
                'number' => $this->reviews->count(),
                'average' => $this->average_rating,
            ],
        ];
    }
}
