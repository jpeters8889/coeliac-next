<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\Nationwide;

use App\Actions\EatingOut\GetMostRatedPlacesInCountyAction;
use App\Actions\EatingOut\GetTopRatedPlacesInCountyAction;
use App\Http\Response\Inertia;
use App\Models\EatingOut\EateryCounty;
use App\Resources\EatingOut\NationwidePageResource;
use Inertia\Response;

class IndexController
{
    public function __invoke(
        Inertia $inertia,
        GetMostRatedPlacesInCountyAction $getMostRatedPlacesInCounty,
        GetTopRatedPlacesInCountyAction $getTopRatedPlacesInCounty
    ): Response {
        /** @var EateryCounty $county */
        $county = EateryCounty::query()->firstWhere('slug', 'nationwide');

        return $inertia
            ->title('Gluten Free Nationwide Chains')
            ->metaDescription('Nationwide chains across the UK that can cater to gluten free diets')
            ->metaTags([
                'coeliac nationwide chains', 'gluten free nationwide chains', 'gluten free food at nationwide chains',
                'gluten free places to eat at chains in the uk', ...$county->keywords(),
            ])
            ->render('EatingOut/Nationwide', [
                'county' => new NationwidePageResource($county),
                'topRated' => fn () => $getMostRatedPlacesInCounty->handle($county),
                'mostRated' => fn () => $getTopRatedPlacesInCounty->handle($county),
            ]);
    }
}
