<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use App\Models\EatingOut\Eatery;
use Illuminate\Support\Collection;

class HydrateEateriesActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 50;

    protected int $reviewsToCreate = 50;

    protected int $branchesToCreate = 50;

    /** @test */
    public function itReturnsTheHydratedEateries(): void
    {
        $hydratedEateries = $this->callHydrateEateriesAction();

        $this->assertInstanceOf(Collection::class, $hydratedEateries->hydrated);
        $this->assertInstanceOf(Eatery::class, $hydratedEateries->hydrated->first());
    }
}
