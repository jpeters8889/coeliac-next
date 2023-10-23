<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut\GetEateriesPipeline;

use App\Models\EatingOut\Eatery;

class AppendDistanceToEateriesTest extends GetEateriesTestCase
{
    /** @test */
    public function itReturnsTheHydratedEateries(): void
    {
        $hydratedEateries = $this->callHydrateEateriesAction();
        $eateriesWithDistance = $this->callAppendDistanceToEateriesMethod($hydratedEateries->eateries, $hydratedEateries->hydrated);

        $eateriesWithDistance->hydrated->each(function (Eatery $eatery): void {
            $this->assertNotNull($eatery->distance);
            $this->assertIsFloat($eatery->distance);
        });
    }
}
