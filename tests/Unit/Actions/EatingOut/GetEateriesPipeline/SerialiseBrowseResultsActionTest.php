<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut\GetEateriesPipeline;

use Illuminate\Support\Collection;

class SerialiseBrowseResultsActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 1;

    protected int $branchesToCreate = 1;

    /** @test */
    public function itReturnsACollectionOfSerialisedEateries(): void
    {
        $pipelineData = $this->callSerialiseBrowseResultsAction();

        $this->assertInstanceOf(Collection::class, $pipelineData->serialisedEateries);
    }

    /** @test */
    public function eachItemInThePaginatorIsTheResource(): void
    {
        $pipelineData = $this->callSerialiseBrowseResultsAction();

        $collection = $pipelineData->serialisedEateries;

        $this->assertInstanceOf($pipelineData->jsonResource, $collection->first());
    }
}
