<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Details\Branches;

use App\Models\EatingOut\NationwideBranch;
use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);

        $this->create(NationwideBranch::class, 10, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    #[Test]
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->postJson(route('api.wheretoeat.branches.index', ['eatery' => 123]))->assertNotFound();
    }

    #[Test]
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->postJson(route('api.wheretoeat.branches.index', ['eatery' => $eatery->id]))->assertNotFound();
    }

    #[Test]
    public function itReturnsNotFoundForAnEateryThatIsntANationwideEatery(): void
    {
        $eatery = $this->build(Eatery::class)->create([
            'county_id' => 2,
        ]);

        $this->postJson(route('api.wheretoeat.branches.index', ['eatery' => $eatery->id]))->assertNotFound();
    }

    protected function searchBranches(string $term): TestResponse
    {
        return $this->postJson(route('api.wheretoeat.branches.index', ['eatery' => $this->eatery->id]), ['term' => $term]);
    }

    #[Test]
    public function itReturnsOkForALiveEatery(): void
    {
        $this->searchBranches('foo')->assertOk();
    }
}
