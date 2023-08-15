<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut;

use App\Actions\EatingOut\GetEateriesPipeline\CheckForMissingEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetEateriesInTownAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetNationwideBranchesInTownAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\PaginateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\RelateEateriesAndBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\SerialiseResultsAction;
use App\Actions\EatingOut\GetEateriesPipeline\SortPendingEateriesAction;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\Models\EatingOut\EateryTown;
use App\Resources\EatingOut\EateryListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;

class GetEateriesPipeline
{
    /**
     * @param  array{categories: string[], features: string[], venueTypes: string []}  $filters
     * @param  class-string<JsonResource>  $jsonResource
     * @return LengthAwarePaginator<JsonResource>
     */
    public function run(EateryTown $town, array $filters, string $jsonResource = EateryListResource::class): LengthAwarePaginator
    {
        $pipes = [
            GetEateriesInTownAction::class,
            GetNationwideBranchesInTownAction::class,
            SortPendingEateriesAction::class,
            PaginateEateriesAction::class,
            HydrateEateriesAction::class,
            HydrateBranchesAction::class,
            CheckForMissingEateriesAction::class,
            RelateEateriesAndBranchesAction::class,
            SerialiseResultsAction::class,
        ];

        $pipelineData = new GetEateriesPipelineData(
            town: $town,
            filters: $filters,
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
