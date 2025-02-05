<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use PHPUnit\Framework\Attributes\Test;

class CheckForMissingEateriesActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 1;

    protected int $branchesToCreate = 9;

    #[Test]
    public function itAddsOnMissingEateries(): void
    {
        $eateries = $this->callHydrateEateriesAction();

        // Will only have 1 due to the nationwide ones being part of the parent
        $this->assertCount(1, $eateries->hydrated);

        $updatedEateries = $this->callCheckForMissingEateriesAction($eateries)->hydrated;

        $this->assertCount(10, $updatedEateries);
    }
}
