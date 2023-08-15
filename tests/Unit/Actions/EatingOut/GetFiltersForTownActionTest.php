<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\GetFiltersForTownAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\EateryVenueType;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class GetFiltersForTownActionTest extends TestCase
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
    public function itReturnsTheFiltersWithTheCorrectKeys(): void
    {
        $this->assertIsArray($this->callAction(GetFiltersForTownAction::class, $this->town));

        $keys = ['categories', 'venueTypes', 'features'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $this->callAction(GetFiltersForTownAction::class, $this->town));
        }
    }

    /** @test */
    public function itReturnsTheEateryCategoryFilters(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['categories'];

        $keys = ['value', 'label', 'disabled', 'checked'];

        foreach ($categoryFilters as $category) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $category);
            }
        }
    }

    /** @test */
    public function eachCategoryFilterIsNotCheckedByDefault(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['categories'];

        foreach ($categoryFilters as $category) {
            $this->assertFalse($category['checked']);
        }
    }

    /** @test */
    public function aFilterCategoryCanBeCheckedViaTheRequest(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town, ['categories' => 'att'])['categories'];

        $this->assertFalse($categoryFilters[0]['checked']); // wte
        $this->assertTrue($categoryFilters[1]['checked']); // att
        $this->assertFalse($categoryFilters[2]['checked']); // hotel
    }

    /** @test */
    public function itReturnsTheEateryVenueTypeFilters(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['venueTypes'];

        $keys = ['value', 'label', 'disabled', 'checked'];

        foreach ($categoryFilters as $category) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $category);
            }
        }
    }

    /** @test */
    public function eachVenueTypeFilterIsNotCheckedByDefault(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['venueTypes'];

        foreach ($categoryFilters as $category) {
            $this->assertFalse($category['checked']);
        }
    }

    /** @test */
    public function aFilterVenueTypeCanBeCheckedViaTheRequest(): void
    {
        $venueType = EateryVenueType::query()->first();

        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town, ['venueTypes' => $venueType->slug])['venueTypes'];

        $this->assertTrue($categoryFilters[0]['checked']);
        $this->assertFalse($categoryFilters[1]['checked']);
        $this->assertFalse($categoryFilters[2]['checked']);
    }

    /** @test */
    public function itReturnsTheEateryFeaturesFilters(): void
    {
        $categoryFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['features'];

        $keys = ['value', 'label', 'disabled', 'checked'];

        foreach ($categoryFilters as $category) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $category);
            }
        }
    }

    /** @test */
    public function eachFeatureFilterIsNotCheckedByDefault(): void
    {
        $featureFilters = $this->callAction(GetFiltersForTownAction::class, $this->town)['features'];

        foreach ($featureFilters as $feature) {
            $this->assertFalse($feature['checked']);
        }
    }

    /** @test */
    public function aFilterFeatureCanBeCheckedViaTheRequest(): void
    {
        $feature = EateryFeature::query()->first();

        $featureFilters = $this->callAction(GetFiltersForTownAction::class, $this->town, ['features' => $feature->slug])['features'];

        $this->assertTrue($featureFilters[0]['checked']);
        $this->assertFalse($featureFilters[1]['checked']);
        $this->assertFalse($featureFilters[2]['checked']);
    }
}
