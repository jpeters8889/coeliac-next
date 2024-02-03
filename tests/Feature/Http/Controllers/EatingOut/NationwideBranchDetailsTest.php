<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class NationwideBranchDetailsTest extends TestCase
{
    protected Eatery $eatery;

    protected NationwideBranch $nationwideBranch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);

        $this->eatery->county->update(['county' => 'Nationwide']);
        $this->eatery->town->update(['town' => 'nationwide']);

        $this->nationwideBranch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    protected function visitEatery(): TestResponse
    {
        return $this->get(route('eating-out.nationwide.show.branch', [
            'eatery' => $this->eatery->slug,
            'nationwideBranch' => $this->nationwideBranch->slug,
        ]));
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
}
