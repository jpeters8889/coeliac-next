<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\RecommendAPlace;

use App\Http\Response\Inertia;
use App\Models\EatingOut\EateryVenueType;
use Inertia\Response;

class CreateController
{
    public function __invoke(Inertia $inertia): Response
    {
        $venueTypes = EateryVenueType::query()
            ->orderBy('venue_type')
            ->get()
            ->map(fn (EateryVenueType $eateryVenueType) => [
                'label' => $eateryVenueType->venue_type,
                'value' => $eateryVenueType->id,
            ]);

        return $inertia
            ->title('Recommend A Place')
            ->doNotTrack()
            ->metaDescription('Recommend a place to be added to the Coeliac Sanctuary gluten free where to eat guide')
            ->render('EatingOut/RecommendAPlace', [
                'venueTypes' => $venueTypes,
            ]);
    }
}
