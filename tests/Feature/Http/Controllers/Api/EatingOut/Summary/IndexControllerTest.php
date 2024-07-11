<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Summary;

use App\Actions\EatingOut\GetEateryStatisticsAction;
use App\DataObjects\EatingOut\EateryStatistics;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itCallsTheGetEateryStatisticsAction(): void
    {
        $this->expectAction(GetEateryStatisticsAction::class, return: new EateryStatistics(1, 2, 3, 4, 5));

        $this->get(route('api.wheretoeat.summary'))->assertOk();
    }
}
