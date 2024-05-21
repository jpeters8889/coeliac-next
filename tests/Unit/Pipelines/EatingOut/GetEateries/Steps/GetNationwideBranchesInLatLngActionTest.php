<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryType;
use App\Models\EatingOut\EateryVenueType;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\Support\Collection;

class GetNationwideBranchesInLatLngActionTest extends GetEateriesTestCase
{
    protected int $eateriesToCreate = 1;

    /** @test */
    public function itReturnsTheNextClosureInTheAction(): void
    {
        $this->assertInstanceOf(GetEateriesPipelineData::class, $this->callGetBranchesInLatLngRadiusAction());
    }

    /** @test */
    public function itReturnsEachEateryAPendingEatery(): void
    {
        $collection = $this->callGetBranchesInLatLngRadiusAction()->eateries;

        $collection->each(fn ($item) => $this->assertInstanceOf(PendingEatery::class, $item));
    }

    /** @test */
    public function itAppendsToThePassedInCollection(): void
    {
        $eateries = new Collection(range(0, 4));

        $newCollection = $this->callGetBranchesInLatLngRadiusAction($eateries);

        $this->assertCount(10, $newCollection->eateries); // 5 in setup, 5 from above
    }

    /** @test */
    public function itCanFilterTheEateriesByCategory(): void
    {
        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => EateryType::ATTRACTION,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => EateryVenueType::query()->first()->id,
            ]);

        $this->build(NationwideBranch::class)
            ->create([
                'wheretoeat_id' => $eatery->id,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $eateries = $this->callGetBranchesInLatLngRadiusAction(filters: ['categories' => ['att']])->eateries;

        $this->assertCount(1, $eateries);
        $this->assertEquals($eatery->id, $eateries->first()->id);
    }

    /** @test */
    public function itCanFilterTheEateriesByVenueType(): void
    {
        $venueType = $this->create(EateryVenueType::class, ['slug' => 'test']);

        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => EateryType::EATERY,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => $venueType->id,
            ]);

        $this->build(NationwideBranch::class)
            ->create([
                'wheretoeat_id' => $eatery->id,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $eateries = $this->callGetBranchesInLatLngRadiusAction(filters: ['venueTypes' => ['test']])->eateries;

        $this->assertCount(1, $eateries);
        $this->assertEquals($eatery->id, $eateries->first()->id);
    }

    /** @test */
    public function itCanFilterTheEateriesByFeature(): void
    {
        $feature = $this->create(EateryFeature::class, ['slug' => 'test']);

        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => EateryType::EATERY,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $feature->eateries()->attach($eatery);

        $this->build(NationwideBranch::class)
            ->create([
                'wheretoeat_id' => $eatery->id,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $eateries = $this->callGetBranchesInLatLngRadiusAction(filters: ['features' => ['test']])->eateries;

        $this->assertCount(1, $eateries);
        $this->assertEquals($eatery->id, $eateries->first()->id);
    }

    /** @test */
    public function itDoesntGetEateriesThatAreMarkedAsClosedDown(): void
    {
        Eatery::query()->update(['closed_down' => true]);

        $eateries = $this->callGetBranchesInLatLngRadiusAction();

        $this->assertCount(0, $eateries->eateries);
    }
}
