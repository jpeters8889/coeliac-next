<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\CheckRecommendedPlace;

use App\DataObjects\EatingOut\RecommendAPlaceExistsCheckData;
use App\Pipelines\EatingOut\CheckRecommendedPlace\CheckRecommendedPlacePipeline;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfLoungeBranch;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfNationwideEatery;
use App\Pipelines\EatingOut\CheckRecommendedPlace\Steps\CheckIfStandardEatery;
use Tests\TestCase;

class CheckRecommendedPlacePipelineTest extends TestCase
{
    /** @test */
    public function itCallsTheActions(): void
    {
        $this->expectPipelineToExecute(CheckIfLoungeBranch::class);
        $this->expectPipelineToExecute(CheckIfNationwideEatery::class);
        $this->expectPipelineToExecute(CheckIfStandardEatery::class);

        $this->runPipeline(CheckRecommendedPlacePipeline::class, new RecommendAPlaceExistsCheckData('foo'));
    }
}
