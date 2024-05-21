<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut\GetEateries\Steps;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use Closure;
use Illuminate\Support\Collection;

class PaginateEateriesAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        /** @var Collection<int, PendingEatery> $eateries */
        $eateries = $pipelineData->eateries;

        $paginatedEateries = $eateries->paginate(10);

        $pipelineData->paginator = $paginatedEateries;

        return $next($pipelineData);
    }
}
