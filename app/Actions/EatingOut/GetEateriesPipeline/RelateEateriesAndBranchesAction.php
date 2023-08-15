<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RelateEateriesAndBranchesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        $hydratedBranches = $pipelineData->hydratedBranches;

        if ( ! $hydratedBranches || $hydratedBranches->count() === 0) {
            return $next($pipelineData);
        }

        /** @var LengthAwarePaginator<PendingEatery> $paginatedEateries */
        $paginatedEateries = $pipelineData->paginator;

        /** @var Collection<int, PendingEatery> $pendingEateries */
        $pendingEateries = collect($paginatedEateries->items());

        /** @var Collection<int, Eatery> $hydratedEateries */
        $hydratedEateries = $pipelineData->hydrated;

        $pipelineData->hydrated = $hydratedEateries->map(function (Eatery $eatery, $index) use ($hydratedBranches, $pendingEateries) {
            /** @var PendingEatery $currentPendingEatery */
            $currentPendingEatery = $pendingEateries->at($index);

            if ($currentPendingEatery->branchId === null) {
                return $eatery;
            }

            /** @var NationwideBranch $currentBranch */
            $currentBranch = $hydratedBranches->firstWhere('id', $currentPendingEatery->branchId);

            $eatery->setRelation('branch', $currentBranch);

            return $eatery;
        });

        return $next($pipelineData);
    }
}
