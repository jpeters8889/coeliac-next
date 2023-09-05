<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Http\Response\Inertia;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Resources\EatingOut\EateryDetailsResource;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Inertia\Response;

class EateryDetailsController
{
    public function __invoke(
        Request $request,
        EateryCounty $county,
        EateryTown $town,
        Eatery $eatery,
        Inertia $inertia,
    ): Response {
        $county->load(['country']);
        $town->setRelation('county', $county);

        $eatery->setRelation('town', $town);
        $eatery->setRelation('county', $county);

        $eatery->load([
            'adminReview', 'adminReview.images', 'reviewImages', 'reviews.images', 'restaurants', 'features', 'openingTimes',
            'reviews' => fn (HasMany $builder) => $builder->latest()->where('admin_review', false),
        ]);

        return $inertia
            ->title("Gluten free at {$eatery->full_name}")
            ->metaDescription("Eat gluten free at {$eatery->full_name}")
            ->metaTags($eatery->keywords())
            ->render('EatingOut/Details', [
                'eatery' => fn () => new EateryDetailsResource($eatery),
            ]);
    }
}
