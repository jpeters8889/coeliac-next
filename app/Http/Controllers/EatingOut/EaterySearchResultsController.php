<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Actions\EatingOut\GetFiltersForEateriesAction;
use App\Http\Response\Inertia;
use App\Models\EatingOut\EaterySearchTerm;
use Illuminate\Http\Request;
use Inertia\Response;

class EaterySearchResultsController
{
    public function __invoke(
        Request $request,
        EaterySearchTerm $searchTerm,
        Inertia $inertia,
        GetFiltersForEateriesAction $getFiltersForEateriesAction
    ): Response {
        $filters = [
            'categories' => $request->has('filter.category') ? explode(',', $request->string('filter.category')->toString()) : null,
            'venueTypes' => $request->has('filter.venueType') ? explode(',', $request->string('filter.venueType')->toString()) : null,
            'features' => $request->has('filter.feature') ? explode(',', $request->string('filter.feature')->toString()) : null,
        ];

        return $inertia
            ->title('search results')
//            ->doNotTrack() @todo
            ->render('EatingOut/Town', [
                //                'eateries' => fn () => $getEateriesPipeline->run($town, $filters),
                //                'filters' => fn () => $getFiltersForEateriesAction->handle($town, $filters),
            ]);
    }
}
