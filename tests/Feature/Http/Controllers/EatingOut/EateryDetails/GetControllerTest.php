<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\EateryDetails;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected Eatery $eatery;

    protected NationwideBranch $nationwideBranch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->eatery = $this->create(Eatery::class);

        $this->nationwideBranch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->get(route('eating-out.show', ['county' => $this->county, 'town' => $this->town, 'eatery' => 'foo']))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->get(route('eating-out.show', ['county' => $this->county, 'town' => $this->town, 'eatery' => $eatery->slug]))->assertNotFound();
    }

    protected function visitEatery(): TestResponse
    {
        return $this->get(route('eating-out.show', ['county' => $this->county, 'town' => $this->town, 'eatery' => $this->eatery->slug]));
    }

    /** @test */
    public function itReturnsOkForALiveEatery(): void
    {
        $this->visitEatery()->assertOk();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitEatery()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/Details')
                    ->has('eatery')
                    ->where('eatery.name', $this->eatery->name)
                    ->etc()
            );
    }

    /** @test */
    public function itReturnsHttpGoneIfTheLocationHasClosedDown(): void
    {
        $this->eatery->update(['closed_down' => true]);

        $this->visitEatery()->assertGone();
    }

    protected function convertToNationwideEatery(): self
    {
        $this->eatery->county->update(['county' => 'Nationwide']);
        $this->eatery->town->update(['town' => 'nationwide']);

        return $this;
    }

    protected function visitNationwideEatery(): TestResponse
    {
        return $this->get(route('eating-out.nationwide.show', ['eatery' => $this->eatery->slug]));
    }

    /** @test */
    public function itReturnsOkForALiveNationwideEatery(): void
    {
        $this
            ->convertToNationwideEatery()
            ->visitNationwideEatery()
            ->assertOk();
    }

    /** @test */
    public function itRendersTheNationwideInertiaPage(): void
    {
        $this
            ->convertToNationwideEatery()
            ->visitNationwideEatery()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/Details')
                    ->has('eatery')
                    ->where('eatery.name', $this->eatery->name)
                    ->etc()
            );
    }

    protected function visitBranch(): TestResponse
    {
        return $this->get(route('eating-out.nationwide.show.branch', [
            'eatery' => $this->eatery->slug,
            'nationwideBranch' => $this->nationwideBranch->slug,
        ]));
    }

    /** @test */
    public function itReturnsOkForALiveBranch(): void
    {
        $this
            ->convertToNationwideEatery()
            ->visitBranch()
            ->assertOk();
    }

    /** @test */
    public function itRendersTheBranchInertiaPage(): void
    {
        $this
            ->convertToNationwideEatery()
            ->visitBranch()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/Details')
                    ->has('eatery')
                    ->where('eatery.name', $this->eatery->name)
                    ->etc()
            );
    }
}
