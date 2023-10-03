<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Http\Response\Inertia;
use App\Models\EatingOut\Eatery;
use App\Resources\EatingOut\EateryDetailsResource;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Inertia\Response;

class NationwideDetailsController
{
    public function __invoke(
        Eatery $eatery,
        Inertia $inertia,
    ): Response {
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
