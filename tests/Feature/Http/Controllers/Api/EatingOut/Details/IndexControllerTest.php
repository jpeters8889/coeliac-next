<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Details;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->getJson(route('api.wheretoeat.get', ['eatery' => 123]))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->getJson(route('api.wheretoeat.get', ['eatery' => $eatery->id]))->assertNotFound();
    }

    protected function visitEatery(): TestResponse
    {
        return $this->getJson(route('api.wheretoeat.get', ['eatery' => $this->eatery->id]));
    }

    /** @test */
    public function itReturnsOkForALiveEatery(): void
    {
        $this->visitEatery()->assertOk();
    }
}
