<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CheckForMissingEateriesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        /** @var LengthAwarePaginator<PendingEatery> $paginator */
        $paginator = $pipelineData->paginator;

        /** @var Collection<int, PendingEatery> $paginatedEateries */
        $paginatedEateries = collect($paginator->items());

        /** @var Collection<int, Eatery> $hydratedEateries */
        $hydratedEateries = $pipelineData->hydrated;

        if ($paginatedEateries->count() === $hydratedEateries->count()) {
            return $next($pipelineData);
        }

        $paginatedEateries->each(function (PendingEatery $pendingEatery, int $index) use (&$hydratedEateries): void {
            if ($hydratedEateries->get($index)?->id === $pendingEatery->id) {
                return;
            }

            /** @var Eatery $duplicateEatery */
            /** @phpstan-ignore-next-line  */
            $duplicateEatery = clone $hydratedEateries->firstWhere('id', $pendingEatery->id);

            $oldEateries = clone $hydratedEateries;

            $hydratedEateries = $oldEateries->take($index);
            $hydratedEateries->push($duplicateEatery);
            $hydratedEateries->push(...$oldEateries->skip($index)->all());
        });

        $pipelineData->hydrated = $hydratedEateries;

        return $next($pipelineData);
    }
}
