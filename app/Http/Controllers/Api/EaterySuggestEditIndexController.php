<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\EatingOut\Eatery;
use App\Resources\EatingOut\Api\EaterySuggestEditIndexResource;

class EaterySuggestEditIndexController
{
    public function __invoke(Eatery $eatery): EaterySuggestEditIndexResource
    {
        $eatery->load(['venueType', 'cuisine', 'openingTimes', 'features']);

        return new EaterySuggestEditIndexResource($eatery);
    }
}
