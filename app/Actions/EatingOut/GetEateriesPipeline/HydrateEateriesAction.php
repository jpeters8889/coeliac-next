<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use Closure;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use RuntimeException;

class HydrateEateriesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        if ($pipelineData->paginator) {
            $eateryIds = Arr::map($pipelineData->paginator->items(), fn (PendingEatery $eatery) => $eatery->id);
        } elseif ($pipelineData->eateries) {
            $eateryIds = $pipelineData->eateries->map(fn (PendingEatery $eatery) => $eatery->id)->toArray();
        } else {
            throw new RuntimeException('No eateries');
        }

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
