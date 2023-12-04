<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryAttractionRestaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Eatery */
class EateryBrowseDetailsResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request)
    {
        /** @var callable(Model): array{name: string, info: string} $formatAttractions */
        $formatAttractions = fn (EateryAttractionRestaurant $restaurant): array => [
            'name' => $restaurant->restaurant_name,
            'info' => $restaurant->info,
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->relationLoaded('branch') ? $this->branch->link() : $this->link(),
            'full_location' => $this->full_location,
            'venue_type' => $this->venueType->venue_type,
            'type' => $this->type->name,
            'cuisine' => $this->cuisine?->cuisine,
            'website' => $this->website,
            'restaurants' => $this->restaurants->map($formatAttractions),
            'info' => $this->info,
            'location' => [
                'address' => collect(explode("\n", $this->address))
                    ->map(fn (string $line) => trim($line))
                    ->join(', '),
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
            'phone' => $this->phone,
            'reviews' => [
                'number' => $this->reviews->count(),
                'average' => (float) $this->average_rating,
            ],
        ];
    }
}
