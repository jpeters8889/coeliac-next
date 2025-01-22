<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Features;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\EatingOut\GetFiltersForEateriesAction;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);
    }

    #[Test]
    public function itCallsTheGetFiltersForTownAction(): void
    {
        $this->expectAction(GetFiltersForEateriesAction::class);

        $this->get(route('api.wheretoeat.features'));
    }
}
