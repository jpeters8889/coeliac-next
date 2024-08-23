<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Nationwide;

use App\Actions\EatingOut\GetMostRatedPlacesInCountyAction;
use App\Actions\EatingOut\GetTopRatedPlacesInCountyAction;
use App\Actions\OpenGraphImages\GetEatingOutOpenGraphImageAction;
use App\Jobs\OpenGraphImages\CreateEatingOutOpenGraphImageJob;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();

        $this->county->update(['slug' => 'nationwide']);

        $this->build(Eatery::class)
            ->create([
                'county_id' => $this->county->id,
            ]);

        Bus::fake(CreateEatingOutOpenGraphImageJob::class);
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->visitPage()->assertOk();
    }

    /** @test */
    public function itCallsTheGetMostRatedPlacesInCountyAction(): void
    {
        $this->expectAction(GetMostRatedPlacesInCountyAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itCallsTheGetTopRatedPlacesInCountyAction(): void
    {
        $this->expectAction(GetTopRatedPlacesInCountyAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itCallsTheGetOpenGraphImageAction(): void
    {
        $this->expectAction(GetEatingOutOpenGraphImageAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitPage()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/Nationwide')
                    ->has('county')
                    ->where('county.name', $this->county->county)
                    ->etc()
            );
    }

    protected function visitPage(): TestResponse
    {
        return $this->get(route('eating-out.nationwide'));
    }
}
