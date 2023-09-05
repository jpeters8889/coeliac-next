<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryAttractionRestaurant;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryReviewImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Eatery */
class EateryDetailsResource extends JsonResource
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
            'menu' => $this->gf_menu_link,
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
                'expense' => $this->average_expense,
                'has_rated' => $this->has_been_rated,
                'images' => $this->approvedReviewImages->count() > 0 ? $this->approvedReviewImages->map(fn (EateryReviewImage $image) => [
                    'id' => $image->id,
                    'thumbnail' => $image->thumb,
                    'path' => $image->path,
                ]) : [],
                'admin_review' => $this->adminReview ? [
                    'published' => $this->adminReview->created_at,
                    'date_diff' => $this->adminReview->human_date,
                    'body' => $this->adminReview->body,
                    'rating' => (float) $this->adminReview->rating,
                    'expense' => $this->adminReview->price,
                    'food_rating' => $this->adminReview->food_rating,
                    'service_rating' => $this->adminReview->service_rating,
                    'branch_name' => $this->adminReview->branch_name,
                    'images' => $this->adminReview->images->count() > 0 ? $this->adminReview->images->map(fn (EateryReviewImage $image) => [
                        'id' => $image->id,
                        'thumbnail' => $image->thumb,
                        'path' => $image->path,
                    ]) : [],
                ] : null,
                'user_reviews' => $this->reviews->map(fn (EateryReview $review) => [
                    'id' => $review->id,
                    'published' => $review->created_at,
                    'date_diff' => $review->human_date,
                    'name' => $review->name,
                    'body' => $review->body,
                    'rating' => (float) $review->rating,
                    'expense' => $review->price,
                    'food_rating' => $review->food_rating,
                    'service_rating' => $review->service_rating,
                    'branch_name' => $review->branch_name,
                    'images' => $review->images->count() > 0 ? $review->images->map(fn (EateryReviewImage $image) => [
                        'id' => $image->id,
                        'thumbnail' => $image->thumb,
                        'path' => $image->path,
                    ]) : [],
                ]),
            ],
            'features' => $this->features->map(fn (EateryFeature $feature) => [
                'name' => $feature->feature,
                'slug' => $feature->slug,
            ]),
            'opening_times' => $this->openingTimes ? [
                'is_open_now' => $this->openingTimes->is_open_now,
                'today' => [
                    'opens' => $this->openingTimes->opensAt(),
                    'closes' => $this->openingTimes->closesAt(),
                ],
                'days' => $this->openingTimes->opening_times_array,
            ] : null,
        ];
    }
}
