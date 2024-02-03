<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Api;

use App\Actions\EatingOut\GetFiltersForEateriesAction;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class EatingOutFeaturesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);
    }

    /** @test */
    public function itCallsTheGetFiltersForTownAction(): void
    {
        $this->expectAction(GetFiltersForEateriesAction::class);

        $this->get(route('api.wheretoeat.features'));
    }
}
