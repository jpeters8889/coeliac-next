<?php

declare(strict_types=1);

namespace App\Resources\EatingOut\Api;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin EateryReview
 */
class EateryApiReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Eatery $eatery */
        $eatery = $this->eatery;

        return [
            'id' => $this->id,
            'eatery_id' => $eatery->id,
            'name' => $eatery->name,
            'location' => $eatery->full_location,
            'full_location' => $eatery->short_location,
            'rating' => $this->rating,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
