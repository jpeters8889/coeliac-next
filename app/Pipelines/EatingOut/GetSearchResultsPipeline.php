<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut;

use App\Actions\EatingOut\GetEateriesPipeline\AppendDistanceToBranches;
use App\Actions\EatingOut\GetEateriesPipeline\AppendDistanceToEateries;
use App\Actions\EatingOut\GetEateriesPipeline\CheckForMissingEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetEateriesInSearchAreaAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetNationwideBranchesInSearchArea;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\PaginateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\RelateEateriesAndBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\SerialiseResultsAction;
use App\Actions\EatingOut\GetEateriesPipeline\SortPendingEateriesAction;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\Models\EatingOut\EaterySearchTerm;
use App\Resources\EatingOut\EateryListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;

class GetSearchResultsPipeline
{
    /**
     * @param  array{categories: string[] | null, features: string[] | null, venueTypes: string [] | null}  $filters
     * @param  class-string<JsonResource>  $jsonResource
     * @return LengthAwarePaginator<JsonResource>
     */
    public function run(EaterySearchTerm $eaterySearchTerm, array $filters, string $jsonResource = EateryListResource::class): LengthAwarePaginator
    {
        $pipes = [
            GetEateriesInSearchAreaAction::class,
            GetNationwideBranchesInSearchArea::class,
            SortPendingEateriesAction::class,
            PaginateEateriesAction::class,
            HydrateEateriesAction::class,
            AppendDistanceToEateries::class,
            HydrateBranchesAction::class,
            AppendDistanceToBranches::class,
            CheckForMissingEateriesAction::class,
            RelateEateriesAndBranchesAction::class,
            SerialiseResultsAction::class,
        ];

        $pipelineData = new GetEateriesPipelineData(
            filters: $filters,
            searchTerm: $eaterySearchTerm,
            jsonResource: $jsonResource
        );

        /** @var GetEateriesPipelineData $pipeline */
        $pipeline = app(Pipeline::class)
            ->send($pipelineData)
            ->through($pipes)
            ->thenReturn();

        /** @var LengthAwarePaginator<JsonResource> $serialisedEateries */
        $serialisedEateries = $pipeline->serialisedEateries;

        return $serialisedEateries;
    }
}
