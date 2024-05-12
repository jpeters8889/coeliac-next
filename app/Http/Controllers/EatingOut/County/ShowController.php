<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\County;

use App\Actions\EatingOut\GetMostRatedPlacesInCountyAction;
use App\Actions\EatingOut\GetTopRatedPlacesInCountyAction;
use App\Http\Response\Inertia;
use App\Models\EatingOut\EateryCounty;
use App\Resources\EatingOut\CountyPageResource;
use Inertia\Response;

class ShowController
{
    public function __invoke(
        EateryCounty $county,
        Inertia $inertia,
        GetMostRatedPlacesInCountyAction $getMostRatedPlacesInCounty,
        GetTopRatedPlacesInCountyAction $getTopRatedPlacesInCounty
    ): Response {
        return $inertia
            ->title("Gluten Free Places to Eat in {$county->county}")
            ->metaDescription("Eateries who can cater to Coeliac and Gluten Free diets in {$county->county} | Gluten free places to eat in {$county->county}")
            ->metaTags($county->keywords())
            ->render('EatingOut/County', [
                'county' => new CountyPageResource($county),
                'topRated' => fn () => $getTopRatedPlacesInCounty->handle($county),
                'mostRated' => fn () => $getMostRatedPlacesInCounty->handle($county),
            ]);
    }
}
