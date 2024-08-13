<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\County\Town;

use App\Actions\EatingOut\GetFiltersForEateriesAction;
use App\Actions\OpenGraphImages\GetOpenGraphImageAction;
use App\Jobs\CreateOpenGraphImageJob;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Pipelines\EatingOut\GetEateries\GetEateriesPipeline;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->create(Eatery::class);

        Bus::fake(CreateOpenGraphImageJob::class);
    }

    /** @test */
    public function itReturnsNotFoundForACountyThatDoesntExistWithAValidTown(): void
    {
        $this->get(route('eating-out.town', ['county' => 'foo', 'town' => $this->town]))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForATownThatDoesntExistWithAValidCounty(): void
    {
        $this->get(route('eating-out.town', ['county' => $this->county, 'town' => 'foo']))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForATownThatHasNoLiveEateries(): void
    {
        $town = $this->create(EateryTown::class);

        $this->get(route('eating-out.town', ['county' => $this->county, 'town' => $town]))->assertNotFound();
    }

    /** @test */
    public function itReturnsOkForACountyThatHasPlaces(): void
    {
        $this->visitTown()->assertOk();
    }

    /** @test */
    public function itCallsTheGetEateriesInTownAction(): void
    {
        $this->expectPipelineToRun(GetEateriesPipeline::class);

        $this->visitTown();
    }

    /** @test */
    public function itCallsTheGetFiltersForTownAction(): void
    {
        $this->expectAction(GetFiltersForEateriesAction::class);

        $this->visitTown();
    }

    /** @test */
    public function itCallsTheGetOpenGraphImageAction(): void
    {
        $this->expectAction(GetOpenGraphImageAction::class);

        $this->visitTown();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitTown()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/Town')
                    ->has('town')
                    ->where('town.name', $this->town->town)
                    ->etc()
            );
    }

    protected function visitTown(): TestResponse
    {
        return $this->get(route('eating-out.town', ['county' => $this->county, 'town' => $this->town]));
    }
}
