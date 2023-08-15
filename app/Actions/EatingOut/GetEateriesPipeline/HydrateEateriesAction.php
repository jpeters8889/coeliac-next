<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use Closure;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class HydrateEateriesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        /** @var LengthAwarePaginator<PendingEatery> $paginator */
        $paginator = $pipelineData->paginator;

        $eateryIds = Arr::map($paginator->items(), fn (PendingEatery $eatery) => $eatery->id);

        $hydratedEateries = Eatery::query()
            ->with([
                'country', 'county', 'town', 'town.county', 'type', 'venueType', 'cuisine', 'restaurants',
                'reviews' => fn (HasMany $builder) => $builder
                    ->select(['id', 'wheretoeat_id', 'rating'])
                    ->where('approved', 1)
                    ->latest(),
            ])
            ->whereIn('id', $eateryIds)
            ->orderByRaw('field(id, ' . Arr::join($eateryIds, ',') . ')')
            ->get();

        $pipelineData->hydrated = $hydratedEateries;

        return $next($pipelineData);
    }
}
