<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

use App\Actions\EatingOut\GetCountyListAction;
use App\Actions\EatingOut\GetMostRatedPlacesAction;
use App\Actions\EatingOut\GetTopRatedPlacesAction;
use App\Models\EatingOut\EateryCounty;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EatingOutIndexTest extends TestCase
{
    protected EateryCounty $county;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EateryScaffoldingSeeder::class);
    }

    protected function visitPage(): TestResponse
    {
        return $this->get(route('eating-out.index'));
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->visitPage()->assertOk();
    }

    /** @test */
    public function itCallsTheGetCountyListAction(): void
    {
        $this->expectAction(GetCountyListAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itCallsTheTopRatedPlacesAction(): void
    {
        $this->expectAction(GetTopRatedPlacesAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itCallsTheMostRatedPlacesAction(): void
    {
        $this->expectAction(GetMostRatedPlacesAction::class);

        $this->visitPage();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitPage()->assertInertia(fn (Assert $page) => $page->component('EatingOut/Index'));
    }
}
