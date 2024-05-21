<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut\CheckRecommendedPlace;

use App\DataObjects\EatingOut\RecommendAPlaceExistsCheckData;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfLoungeBranch;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfNationwideEatery;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfStandardEatery;
use Illuminate\Pipeline\Pipeline;

class CheckRecommendedPlacePipeline
{
    public function run(RecommendAPlaceExistsCheckData $data): RecommendAPlaceExistsCheckData
    {
        $pipes = [
            CheckIfLoungeBranch::class,
            CheckIfNationwideEatery::class,
            CheckIfStandardEatery::class,
        ];

        /** @var RecommendAPlaceExistsCheckData $pipeline */
        $pipeline = app(Pipeline::class)
            ->send($data)
            ->through($pipes)
            ->thenReturn();

        return $pipeline;
    }
}
