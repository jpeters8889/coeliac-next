<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut\GetEateries\Steps;

use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryVenueType;
use Illuminate\Support\Collection;

class GetEateriesInTownActionTest extends GetEateriesTestCase
{
    /** @test */
    public function itReturnsTheNextClosureInTheAction(): void
    {
        $this->assertInstanceOf(GetEateriesPipelineData::class, $this->callGetEateriesInTownAction());
    }

    /** @test */
    public function itReturnsEachEateryAPendingEatery(): void
    {
        $collection = $this->callGetEateriesInTownAction()->eateries;

        $collection->each(fn ($item) => $this->assertInstanceOf(PendingEatery::class, $item));
    }

    /** @test */
    public function itAppendsToThePassedInCollection(): void
    {
        $eateries = new Collection(range(0, 4));

        $newCollection = $this->callGetEateriesInTownAction($eateries)->eateries;

        $this->assertCount(10, $newCollection); // 5 in setup, 5 from above
    }

    /** @test */
    public function itCanFilterTheEateriesByCategory(): void
    {
        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => 2,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => EateryVenueType::query()->first()->id,
            ]);

        $eateries = $this->callGetEateriesInTownAction(filters: ['categories' => ['att']]);

        $this->assertCount(1, $eateries->eateries);
        $this->assertEquals($eatery->id, $eateries->eateries->first()->id);
    }

    /** @test */
    public function itCanFilterTheEateriesByVenueType(): void
    {
        $venueType = $this->create(EateryVenueType::class, ['slug' => 'test']);

        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => 1,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => $venueType->id,
            ]);

        $eateries = $this->callGetEateriesInTownAction(filters: ['venueTypes' => ['test']]);

        $this->assertCount(1, $eateries->eateries);
        $this->assertEquals($eatery->id, $eateries->eateries->first()->id);
    }

    /** @test */
    public function itCanFilterTheEateriesByFeature(): void
    {
        $feature = $this->create(EateryFeature::class, ['slug' => 'test']);

        $eatery = $this->build(Eatery::class)
            ->create([
                'type_id' => 1,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $feature->eateries()->attach($eatery);

        $eateries = $this->callGetEateriesInTownAction(filters: ['features' => ['test']]);

        $this->assertCount(1, $eateries->eateries);
        $this->assertEquals($eatery->id, $eateries->eateries->first()->id);
    }

    /** @test */
    public function itDoesntGetEateriesThatAreMarkedAsClosedDown(): void
    {
        Eatery::query()->update(['closed_down' => true]);

        $eateries = $this->callGetEateriesInTownAction();

        $this->assertCount(0, $eateries->eateries);
    }
}
