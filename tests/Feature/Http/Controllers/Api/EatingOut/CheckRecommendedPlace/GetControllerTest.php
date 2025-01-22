<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\CheckRecommendedPlace;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\EatingOut\RecommendAPlaceExistsCheckData;
use App\Pipelines\EatingOut\CheckRecommendedPlace\CheckRecommendedPlacePipeline;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    #[Test]
    public function itCallsTheCheckRecommendedPlacePipeline(): void
    {
        $this->expectPipelineToRun(CheckRecommendedPlacePipeline::class, new RecommendAPlaceExistsCheckData(found: false));

        $request = $this->post(route('api.wheretoeat.check-recommended-place'));

        $this->assertTrue($request->status() < 300);
    }
}
