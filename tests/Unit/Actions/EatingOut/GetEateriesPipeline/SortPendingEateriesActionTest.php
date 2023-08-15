<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut\GetEateriesPipeline;

use App\DataObjects\EatingOut\PendingEatery;

class SortPendingEateriesActionTest extends GetEateriesTestCase
{
    /** @test */
    public function itSortsEateries(): void
    {
        $eateries = $this->callGetEateriesAction()->eateries;
        $eateries = $this->callGetBranchesAction($eateries)->eateries;

        $sortedEateries = $this->callSortEateriesAction($eateries)->eateries;

        $eateryNames = $sortedEateries->map(fn (PendingEatery $eatery) => $eatery->ordering)->toArray();

        $this->assertSortedAlphabetically($eateryNames);
    }
}
