<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;

class SerialiseBrowseResultsActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 1;

    protected int $branchesToCreate = 1;

    #[Test]
    public function itReturnsACollectionOfSerialisedEateries(): void
    {
        $pipelineData = $this->callSerialiseBrowseResultsAction();

        $this->assertInstanceOf(Collection::class, $pipelineData->serialisedEateries);
    }

    #[Test]
    public function eachItemInThePaginatorIsTheResource(): void
    {
        $pipelineData = $this->callSerialiseBrowseResultsAction();

        $collection = $pipelineData->serialisedEateries;

        $this->assertInstanceOf($pipelineData->jsonResource, $collection->first());
    }
}
