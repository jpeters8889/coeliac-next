<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\Eatery;

class AppendDistanceToEateriesTest extends GetEateriesTestCase
{
    #[Test]
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
