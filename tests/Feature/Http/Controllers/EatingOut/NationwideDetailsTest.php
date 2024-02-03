<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

use App\Models\EatingOut\Eatery;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class NationwideDetailsTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);

        $this->eatery->county->update(['county' => 'Nationwide']);
        $this->eatery->town->update(['town' => 'nationwide']);
    }

    protected function visitEatery(): TestResponse
    {
        return $this->get(route('eating-out.nationwide.show', ['eatery' => $this->eatery->slug]));
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
