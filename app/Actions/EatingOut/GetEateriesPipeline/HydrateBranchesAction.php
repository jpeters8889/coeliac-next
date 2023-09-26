<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\NationwideBranch;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;

class HydrateBranchesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        /** @var LengthAwarePaginator<PendingEatery> $paginator */
        $paginator = $pipelineData->paginator;

        $branchIds = collect($paginator->items())
            ->reject(fn (PendingEatery $eatery) => $eatery->branchId === null)
            ->map(fn (PendingEatery $eatery) => $eatery->branchId)
            ->values()
            ->toArray();

        if (count($branchIds) === 0) {
            return $next($pipelineData);
        }

        $hydratedBranches = NationwideBranch::query()
            ->whereIn('id', $branchIds)
            ->with(['county', 'town'])
            ->get();

        $pipelineData->hydratedBranches = $hydratedBranches;

        return $next($pipelineData);
    }
}
