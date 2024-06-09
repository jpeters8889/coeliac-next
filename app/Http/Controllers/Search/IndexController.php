<?php

declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\DataObjects\Search\SearchParameters;
use App\Http\Requests\Search\SearchRequest;
use App\Http\Response\Inertia;
use App\Models\Search\SearchHistory;
use App\Pipelines\Search\PerformSearchPipeline;
use App\Support\Search\SearchState;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, SearchRequest $request, PerformSearchPipeline $performSearchPipeline): Response
    {
        $referrer = URL::previousPath();

        $searchHistory = SearchHistory::query()->firstOrCreate(['term' => $request->string('q')->toString()]);

        $searchHistory->increment('number_of_searches');

        if ( ! Str::contains($referrer, '/search')) {
            // use ai to see best place to look, if not already set in database (add migration for new column);
        }

        $results = $performSearchPipeline->run(SearchParameters::fromRequest($request));

        return $inertia
            ->title("{$request->string('q')->toString()} - Search Results")
            ->doNotTrack()
            ->render('Search/Index', [
                'parameters' => $request->validated(),
                'results' => $results,
                'hasEatery' => SearchState::$hasGeoSearched,
            ]);
    }
}
