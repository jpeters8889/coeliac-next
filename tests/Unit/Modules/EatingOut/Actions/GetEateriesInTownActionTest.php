<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Actions;

use App\Actions\EatingOut\GetEateriesInTownAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\EateryVenueType;
use App\Resources\EatingOut\EateryListCollection;
use App\Resources\EatingOut\EateryListResource;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class GetEateriesInTownActionTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->build(Eatery::class)
            ->count(5)
            ->create([
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => EateryVenueType::query()->first()->id,
            ]);

        EateryFeature::query()->first()->eateries()->attach(Eatery::query()->first());

        $this->county->eateries->each(function (Eatery $eatery, $index): void {
            $this->build(EateryReview::class)
                ->count(5 - $index)
                ->create([
                    'wheretoeat_id' => $eatery->id,
                    'rating' => 5 - $index,
                    'approved' => true,
                ]);
        });
    }

    /** @test */
    public function itReturnsTheEateriesAsACollectionResource(): void
    {
        $this->assertInstanceOf(EateryListCollection::class, $this->callAction(GetEateriesInTownAction::class, $this->town));
    }

    /** @test */
    public function theEateryCollectionIsPaginated(): void
    {
        $this->assertInstanceOf(LengthAwarePaginator::class, $this->callAction(GetEateriesInTownAction::class, $this->town)->resource);
    }

    /** @test */
    public function itReturnsEachEateryInTheCollectionAsAnEateryListResource(): void
    {
        $collection = $this->callAction(GetEateriesInTownAction::class, $this->town);

        $collection->collection->each(fn ($item) => $this->assertInstanceOf(EateryListResource::class, $item));
    }

    /** @test */
    public function itCanFilterTheEateriesByCategory(): void
    {
        $this->build(Eatery::class)
            ->create([
                'name' => 'Attraction',
                'type_id' => 2,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => EateryVenueType::query()->first()->id,
            ]);

        $eateries = $this->callAction(GetEateriesInTownAction::class, $this->town, ['categories' => ['att']]);

        $this->assertCount(1, $eateries);
        $this->assertEquals('Attraction', $eateries->first()->name);
    }

    /** @test */
    public function itCanFilterTheEateriesByVenueType(): void
    {
        $venueType = $this->create(EateryVenueType::class, ['slug' => 'test']);

        $this->build(Eatery::class)
            ->create([
                'name' => 'This Venue',
                'type_id' => 1,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => $venueType->id,
            ]);

        $eateries = $this->callAction(GetEateriesInTownAction::class, $this->town, ['venueTypes' => ['test']]);

        $this->assertCount(1, $eateries);
        $this->assertEquals('This Venue', $eateries->first()->name);
    }

    /** @test */
    public function itCanFilterTheEateriesByFeature(): void
    {
        $feature = $this->create(EateryFeature::class, ['slug' => 'test']);

        $eatery = $this->build(Eatery::class)
            ->create([
                'name' => 'This Feature',
                'type_id' => 1,
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
            ]);

        $feature->eateries()->attach($eatery);

        $eateries = $this->callAction(GetEateriesInTownAction::class, $this->town, ['features' => ['test']]);

        $this->assertCount(1, $eateries);
        $this->assertEquals('This Feature', $eateries->first()->name);
    }
}
