<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut;

use App\Pipelines\EatingOut\GetEateries\GetFilteredEateriesPipeline;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itCallsTheGetFilteredEateriesPipelineAction(): void
    {
        $this->expectPipelineToRun(GetFilteredEateriesPipeline::class);

        $this->get(route('api.wheretoeat.index'));
    }
}
