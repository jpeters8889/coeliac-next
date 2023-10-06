<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\GetTopRatedPlacesInCountyAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Support\Facades\Cache;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class GetTopRatedPlacesInCountyActionTest extends TestCase
{
    protected EateryCounty $county;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();

        $this->build(Eatery::class)
            ->count(5)
            ->create(['county_id' => $this->county->id]);

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
    public function itOrdersTheEateriesByTheNumberRating(): void
    {
        $eateries = $this->callAction(GetTopRatedPlacesInCountyAction::class, $this->county);

        $this->assertGreaterThan($eateries->skip(1)->first()->rating_count, $eateries->first()->rating_count);
    }

    /** @test */
    public function itCachesTheMostRatedPlaces(): void
    {
        $this->assertFalse(Cache::has("wheretoeat_county_{$this->county->slug}_top_rated_places"));

        $this->callAction(GetTopRatedPlacesInCountyAction::class, $this->county);

        $this->assertTrue(Cache::has("wheretoeat_county_{$this->county->slug}_top_rated_places"));
    }

    /** @test */
    public function theMostRatedPlacesCacheExpiresAfter24Hours(): void
    {
        TestTime::freeze();

        $this->assertFalse(Cache::has("wheretoeat_county_{$this->county->slug}_top_rated_places"));

        $this->callAction(GetTopRatedPlacesInCountyAction::class, $this->county);

        $this->assertTrue(Cache::has("wheretoeat_county_{$this->county->slug}_top_rated_places"));

        TestTime::addHours(25);

        $this->assertFalse(Cache::has("wheretoeat_county_{$this->county->slug}_top_rated_places"));
    }

    /** @test */
    public function itGetsTheMostRatedPlacesOutOfTheCacheIfTheyExist(): void
    {
        $this->callAction(GetTopRatedPlacesInCountyAction::class, $this->county);

        app('db')->enableQueryLog();

        $this->callAction(GetTopRatedPlacesInCountyAction::class, $this->county);

        $this->assertEmpty(app('db')->getQueryLog());
    }
}
