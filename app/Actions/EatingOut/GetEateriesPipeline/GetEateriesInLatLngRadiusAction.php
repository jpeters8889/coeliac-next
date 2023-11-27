<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use RuntimeException;

class GetEateriesInLatLngRadiusAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        if ( ! $pipelineData->latLng || ! $pipelineData->latLng->radius) {
            throw new RuntimeException('No Lat/Lng');
        }

        /** @var Builder<Eatery> $idQuery */
        $idQuery = Eatery::databaseSearchAroundLatLng($pipelineData->latLng, $pipelineData->latLng->radius)
            ->whereRaw('(select county from wheretoeat_counties where wheretoeat_counties.id = wheretoeat.county_id) != ?', ['Nationwide']);

        if (Arr::has($pipelineData->filters, 'categories') && $pipelineData->filters['categories'] !== null) {
            $idQuery = $idQuery->hasCategories($pipelineData->filters['categories']);
        }

        if (Arr::has($pipelineData->filters, 'venueTypes') && $pipelineData->filters['venueTypes'] !== null) {
            $idQuery = $idQuery->hasVenueTypes($pipelineData->filters['venueTypes']);
        }

        if (Arr::has($pipelineData->filters, 'features') && $pipelineData->filters['features'] !== null) {
            $idQuery = $idQuery->hasFeatures($pipelineData->filters['features']);
        }

        /** @var EloquentCollection<int, Eatery> $eateries */
        $eateries = $idQuery->get();

        $pendingEateries = $eateries->map(fn (Eatery $eatery) => new PendingEatery(
            id: $eatery->id,
            branchId: null,
            ordering: $eatery->name,
            lat: $eatery->lat,
            lng: $eatery->lng,
        ));

        if ( ! $pipelineData->eateries instanceof Collection) {
            $pipelineData->eateries = new Collection();
        }

        $pipelineData->eateries->push(...$pendingEateries);

        return $next($pipelineData);
    }
}
