<?php

declare(strict_types=1);

namespace App\Pipelines\Search\Steps;

use App\DataObjects\Search\SearchPipelineData;
use App\DataObjects\Search\SearchResultItem;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use App\Search\Eateries;
use App\Support\Helpers;
use App\Support\Search\SearchState;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Geocoder\Facades\Geocoder;

class SearchEateries
{
    public function handle(SearchPipelineData $searchPipelineData, Closure $next): mixed
    {
        if ($searchPipelineData->parameters->eateries) {
            /** @var Collection<int, Eatery|NationwideBranch> $baseResults */
            $baseResults = Eateries::search($searchPipelineData->parameters->term)
                ->with([
                    'getRankingInfo' => true,
                ])
                ->take(100)
                ->get();

            $geocoder = Geocoder::getCoordinatesForAddress($searchPipelineData->parameters->term);

            $geoResults = collect();

            if ($geocoder['accuracy'] !== 'result_not_found') {
                /** @var Collection<int, Eatery|NationwideBranch> $geoResults */
                $geoResults = Eateries::search()
                    ->with([
                        'getRankingInfo' => true,
                        'aroundLatLng' => implode(', ', [$geocoder['lat'], $geocoder['lng']]),
                        'aroundRadius' => Helpers::milesToMeters(5),
                    ])
                    ->take(100)
                    ->get();

                $geoResults = $geoResults->map(function (Eatery|NationwideBranch $eatery) {
                    $eatery->setAttribute('_resDistance', Arr::get($eatery->scoutMetadata(), '_rankingInfo.geoDistance', 0));

                    return $eatery;
                });

                SearchState::$hasGeoSearched = true;
            }

            $baseResults = $baseResults->map(function (Eatery|NationwideBranch $eatery) use ($geoResults) {
                /** @var Eatery|NationwideBranch|null $geoResult */
                $geoResult = $geoResults->where('id', $eatery->id)
                    ->where('slug', $eatery->slug)
                    ->first();

                if ($geoResult && $geoResult->hasAttribute('_resDistance')) {
                    $eatery->setAttribute('_resDistance', $geoResult->getAttribute('_resDistance'));
                }

                return $eatery;
            });

            $results = collect([...$geoResults->all(), ...$baseResults->all()])
                ->map(fn (Eatery|NationwideBranch $eatery) => SearchResultItem::fromSearchableResult($eatery))
                ->unique(fn (SearchResultItem $item) => "{$item->model}#{$item->id}");

            $searchPipelineData
                ->results
                ->eateries
                ->push(...$results->all());
        }

        return $next($searchPipelineData);
    }
}
