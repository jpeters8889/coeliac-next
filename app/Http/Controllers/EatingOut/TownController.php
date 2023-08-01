<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Actions\EatingOut\GetEateriesInTownAction;
use App\Actions\EatingOut\GetFiltersForTownAction;
use App\Http\Response\Inertia;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Resources\EatingOut\TownPageResource;
use Illuminate\Http\Request;
use Inertia\Response;

class TownController
{
    public function __invoke(
        Request                 $request,
        EateryCounty            $county,
        EateryTown              $town,
        Inertia                 $inertia,
        GetEateriesInTownAction $getEateriesInTown,
        GetFiltersForTownAction $getFiltersForTown,
    ): Response {
        $filters = [
            'categories' => $request->has('filter.category') ? explode(',', $request->string('filter.category')->toString()) : null,
            'venueTypes' => $request->has('filter.venueType') ? explode(',', $request->string('filter.venueType')->toString()) : null,
            'features' => $request->has('filter.feature') ? explode(',', $request->string('filter.feature')->toString()) : null,
        ];

        $county->load(['country']);
        $town->setRelation('county', $county);

        return $inertia
            ->title("Gluten Free Places to Eat in {$town->town}, {$county->county}")
            ->metaDescription("Coeliac Sanctuary gluten free places in {$town->town}, {$county->county} | Places can cater to Coeliac and Gluten Free diets in {$town->town}, {$county->county}!")
            ->metaTags($town->keywords())
            ->render('EatingOut/Town', [
                'town' => fn () => new TownPageResource($town),
                'eateries' => fn () => $getEateriesInTown($town, $filters),
                'filters' => fn () => $getFiltersForTown($town),
            ]);
    }
}