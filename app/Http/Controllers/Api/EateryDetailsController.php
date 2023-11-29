<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\EatingOut\Eatery;
use App\Resources\EatingOut\EateryBrowseDetailsResource;

class EateryDetailsController
{
    public function __invoke(Eatery $eatery): EateryBrowseDetailsResource
    {
        $eatery->load([
            'country', 'county', 'town', 'town.county', 'restaurants', 'venueType', 'type', 'cuisine', 'reviews',
        ]);

        return new EateryBrowseDetailsResource($eatery);
    }
}
