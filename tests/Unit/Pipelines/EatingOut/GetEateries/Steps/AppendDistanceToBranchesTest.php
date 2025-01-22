<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\NationwideBranch;

class AppendDistanceToBranchesTest extends GetEateriesTestCase
{
    #[Test]
    public function itReturnsTheHydratedBranches(): void
    {
        $hydratedEateries = $this->callHydrateBranchesAction();
        $eateriesWithDistance = $this->callAppendDistanceToBranchesMethod($hydratedEateries->eateries, $hydratedEateries->hydratedBranches);

        $eateriesWithDistance->hydratedBranches->each(function (NationwideBranch $branch): void {
            $this->assertNotNull($branch->distance);
            $this->assertIsFloat($branch->distance);
        });
    }
}
