<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\Http;

use App\Actions\EatingOut\GetMostRatedPlacesInCountyAction;
use App\Actions\EatingOut\GetTopRatedPlacesInCountyAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CountyTest extends TestCase
{
    protected EateryCounty $county;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();

        $this->build(Eatery::class)
            ->create([
                'county_id' => $this->county->id,
            ]);
    }

    /** @test */
    public function itReturnsNotFoundForACountyThatDoesntExist(): void
    {
        $this->get(route('eating-out.county', ['county' => 'foobar']))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForACountyThatHasNoLiveEateries(): void
    {
        $county = $this->create(EateryCounty::class);

        $this->get(route('eating-out.county', ['county' => $county]))->assertNotFound();
    }

    protected function visitCounty(): TestResponse
    {
        return $this->get(route('eating-out.county', ['county' => $this->county]));
    }

    /** @test */
    public function itReturnsOkForACountyThatHasPlaces(): void
    {
        $this->visitCounty()->assertOk();
    }

    /** @test */
    public function itCallsTheGetMostRatedPlacesInCountyAction(): void
    {
        $this->expectAction(GetMostRatedPlacesInCountyAction::class);

        $this->visitCounty();
    }

    /** @test */
    public function itCallsTheGetTopRatedPlacesInCountyAction(): void
    {
        $this->expectAction(GetTopRatedPlacesInCountyAction::class);

        $this->visitCounty();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitCounty()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/County')
                    ->has('county')
                    ->where('county.name', $this->county->county)
                    ->etc()
            );
    }
}
