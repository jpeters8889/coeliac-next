<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginateEateriesActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 50;

    protected int $reviewsToCreate = 50;

    protected int $branchesToCreate = 50;

    /** @test */
    public function itCreatesAPaginator(): void
    {
        $paginatedEateries = $this->callPaginateEateriesAction();

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginatedEateries->paginator);
    }

    /** @test */
    public function itReturns10ItemsPerPage(): void
    {
        /** @var LengthAwarePaginator $paginatedEateries */
        $paginatedEateries = $this->callPaginateEateriesAction()->paginator;

        $this->assertCount(10, $paginatedEateries->items());
    }
}
