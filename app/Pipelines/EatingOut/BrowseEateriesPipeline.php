<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut;

use App\Actions\EatingOut\GetEateriesPipeline\GetEateriesInLatLngRadiusAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetNationwideBranchesInLatLngAction;
use App\Actions\EatingOut\GetEateriesPipeline\SerialiseBrowseResultsAction;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\LatLng;
use App\Resources\EatingOut\EateryBrowseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class BrowseEateriesPipeline
{
    /**
     * @param  array{categories: string[] | null, features: string[] | null, venueTypes: string[] | null}  $filters
     * @param  class-string<JsonResource>  $jsonResource
     * @return Collection<int, JsonResource>
     */
    public function run(LatLng $latLng, array $filters, string $jsonResource = EateryBrowseResource::class): Collection
    {
        $pipes = [
            GetEateriesInLatLngRadiusAction::class,
            GetNationwideBranchesInLatLngAction::class,
            SerialiseBrowseResultsAction::class,
        ];

        $pipelineData = new GetEateriesPipelineData(
            filters: $filters,
            latLng: $latLng,
            jsonResource: $jsonResource
        );

        /** @var GetEateriesPipelineData $pipeline */
        $pipeline = app(Pipeline::class)
            ->send($pipelineData)
            ->through($pipes)
            ->thenReturn();

        /** @var Collection<int, JsonResource> $serialisedEateries */
        $serialisedEateries = $pipeline->serialisedEateries;

        return $serialisedEateries;
    }
}
