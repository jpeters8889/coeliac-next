<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\NationwideBranch;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use RuntimeException;

class GetNationwideBranchesInLatLngAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        if ( ! $pipelineData->latLng || ! $pipelineData->latLng->radius) {
            throw new RuntimeException('No Lat/Lng');
        }

        /** @var Builder<NationwideBranch> $idQuery */
        $idQuery = NationwideBranch::databaseSearchAroundLatLng($pipelineData->latLng, $pipelineData->latLng->radius)
            ->whereHas('eatery', function ($query) use ($pipelineData) {
                if (Arr::has($pipelineData->filters, 'categories') && $pipelineData->filters['categories'] !== null) {
                    $query = $query->hasCategories($pipelineData->filters['categories']);
                }

                if (Arr::has($pipelineData->filters, 'venueTypes') && $pipelineData->filters['venueTypes'] !== null) {
                    $query = $query->hasVenueTypes($pipelineData->filters['venueTypes']);
                }

                if (Arr::has($pipelineData->filters, 'features') && $pipelineData->filters['features'] !== null) {
                    $query = $query->hasFeatures($pipelineData->filters['features']);
                }

                return $query;
            });

        /** @var EloquentCollection<int, NationwideBranch> $eateries */
        $eateries = $idQuery->get();

        $pendingEateries = $eateries->map(fn (NationwideBranch $eatery) => new PendingEatery(
            id: $eatery->wheretoeat_id,
            branchId: $eatery->id,
            ordering: (string) $eatery->distance,
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
