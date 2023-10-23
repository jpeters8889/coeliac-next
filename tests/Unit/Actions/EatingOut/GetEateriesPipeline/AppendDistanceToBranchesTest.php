<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut\GetEateriesPipeline;

use App\Models\EatingOut\NationwideBranch;

class AppendDistanceToBranchesTest extends GetEateriesTestCase
{
    /** @test */
    public function itReturnsTheHydratedEateries(): void
    {
        $hydratedEateries = $this->callHydrateBranchesAction();
        $eateriesWithDistance = $this->callAppendDistanceToBranchesMethod($hydratedEateries->eateries, $hydratedEateries->hydratedBranches);

        $this->assertTrue(true);

        $eateriesWithDistance->hydratedBranches->each(function (NationwideBranch $branch): void {
            $this->assertNotNull($branch->distance);
            $this->assertIsFloat($branch->distance);
        });
    }
}
