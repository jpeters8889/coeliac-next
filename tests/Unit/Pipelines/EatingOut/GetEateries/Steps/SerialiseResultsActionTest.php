<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Pagination\LengthAwarePaginator;

class SerialiseResultsActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 1;

    protected int $branchesToCreate = 1;

    #[Test]
    public function itCreatesAPaginatorInstanceForSerialisedEateries(): void
    {
        $pipelineData = $this->callSerialiseResultsAction();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pipelineData->serialisedEateries);
    }

    #[Test]
    public function eachItemInThePaginatorIsTheResource(): void
    {
        $pipelineData = $this->callSerialiseResultsAction();

        $paginator = $pipelineData->serialisedEateries;

        $this->assertInstanceOf($pipelineData->jsonResource, $paginator->items()[0]);
    }
}
