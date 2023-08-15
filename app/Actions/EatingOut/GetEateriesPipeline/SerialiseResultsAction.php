<?php

declare(strict_types=1);

namespace App\Actions\EatingOut\GetEateriesPipeline;

use App\Contracts\EatingOut\GetEateriesPipelineActionContract;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SerialiseResultsAction implements GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed
    {
        /** @var Collection<int, Eatery> $eateries */
        $eateries = $pipelineData->hydrated;

        /** @var LengthAwarePaginator<PendingEatery> $paginator */
        $paginator = $pipelineData->paginator;

        /** @var LengthAwarePaginator<JsonResource> $serialisedPaginator */
        $serialisedPaginator = $paginator->setCollection(
            $eateries->map(fn (Eatery $eatery) => new ($pipelineData->jsonResource)($eatery))
        );

        $pipelineData->serialisedEateries = $serialisedPaginator;

        return $next($pipelineData);
    }
}
