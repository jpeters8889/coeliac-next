<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\Search;

use App\Actions\EatingOut\GetFiltersForEateriesAction;
use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EaterySearchTerm;
use App\Pipelines\EatingOut\GetEateries\GetSearchResultsPipeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Response;

class ShowController
{
    public function __invoke(
        Request $request,
        EaterySearchTerm $eaterySearchTerm,
        Inertia $inertia,
        GetSearchResultsPipeline $getSearchResultsPipeline,
        GetFiltersForEateriesAction $getFiltersForEateriesAction,
        GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction,
    ): Response {
        /** @var array{categories: string[] | null, features: string[] | null, venueTypes: string [] | null, county: string | int | null } $filters */
        $filters = [
            'categories' => $request->has('filter.category') ? explode(',', $request->string('filter.category')->toString()) : null,
            'venueTypes' => $request->has('filter.venueType') ? explode(',', $request->string('filter.venueType')->toString()) : null,
            'features' => $request->has('filter.feature') ? explode(',', $request->string('filter.feature')->toString()) : null,
        ];

        $eateries = $getSearchResultsPipeline->run($eaterySearchTerm, $filters);

        return $inertia
            ->title("{$eaterySearchTerm->term} - Search Results")
            ->metaImage($getOpenGraphImageForRouteAction->handle('eatery'))
            ->doNotTrack()
            ->render('EatingOut/SearchResults', [
                'term' => fn () => $eaterySearchTerm->term,
                'image' => EateryCountry::query()->where('country', 'England')->firstOrFail()->image,
                'eateries' => fn () => $eateries,
                'filters' => fn () => $getFiltersForEateriesAction->handle(fn (Builder $query) => $query->whereIn('id', Arr::pluck($eateries->all(), 'id')), $filters),
            ]);
    }
}
