<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryAttractionRestaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Eatery */
class EateryListResource extends JsonResource
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
            'name' => $this->name,
            'link' => $this->link(),
            'county' => [
                'id' => $this->county_id,
                'name' => $this->county->county,
                'link' => $this->county->link(),
            ],
            'town' => [
                'id' => $this->town_id,
                'name' => $this->town->town,
                'link' => $this->town->link(),
            ],
            'venue_type' => $this->venueType?->venue_type,
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
                'average' => $this->average_rating,
            ],
        ];
    }
}
