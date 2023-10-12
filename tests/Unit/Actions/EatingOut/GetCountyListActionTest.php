<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\GetCountyListAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GetCountyListActionTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        foreach (range(2, 6) as $index) {
            $country = $this->build(EateryCountry::class)
                ->state([
                    'id' => $index,
                    'country' => $this->faker->unique->country,
                ])
                ->create();

            $counties = $this->build(EateryCounty::class)
                ->state(['country_id' => $country->id])
                ->count(5)
                ->create();

            $counties->each(function (EateryCounty $county) use ($country): void {
                $towns = $this->build(EateryTown::class)
                    ->state(['county_id' => $county->id])
                    ->count(5)
                    ->create();

                $towns->each(function (EateryTown $town) use ($county, $country): void {
                    $this->build(Eatery::class)
                        ->state(['country_id' => $country->id, 'county_id' => $county->id, 'town_id' => $town->id])
                        ->count(5)
                        ->create();
                });
            });
        }
    }

    /** @test */
    public function itReturnsACollection(): void
    {
        $this->assertInstanceOf(
            Collection::class,
            app(GetCountyListAction::class)->handle(),
        );
    }

    /** @test */
    public function itReturnsTheCountriesGroupedByCountry(): void
    {
        $collection = app(GetCountyListAction::class)->handle();
        $countries = EateryCountry::query()
            ->whereHas('eateries', fn (Builder $builder) => $builder->where('live', true))
            ->pluck('country');

        $this->assertArrayHasKeys($countries, $collection);
    }

    /** @test */
    public function eachCountryHasAListPropertyThatIsAnArray(): void
    {
        $collection = app(GetCountyListAction::class)->handle();

        $collection->each(function (array $item): void {
            $this->assertArrayHasKey('list', $item);
        });
    }

    /** @test */
    public function eachCountryListHasANameSlugAndTotal(): void
    {
        $collection = app(GetCountyListAction::class)->handle();

        $collection->each(function (array $item): void {
            foreach ($item['list'] as $county) {
                $this->assertArrayHasKeys(['name', 'slug', 'total'], (array) $county);
            }
        });
    }

    /** @test */
    public function eachCountryListHasTheCountiesInThatCounty(): void
    {
        $collection = app(GetCountyListAction::class)->handle();

        $collection->each(function (array $item, string $country): void {
            $listedCounties = collect($item['list'])->map(fn ($county) => (array)$county)->pluck('name');

            EateryCountry::query()
                ->firstWhere('country', $country)
                ->counties()
                ->whereHas('eateries', fn (Builder $builder) => $builder->where('live', true))
                ->pluck('county')
                ->each(fn ($county) => $this->assertContains($county, $listedCounties));
        });
    }

    /** @test */
    public function itListsTheNumberOfCountiesInEachCountry(): void
    {
        $collection = app(GetCountyListAction::class)->handle();

        $collection->each(function (array $item): void {
            $this->assertArrayHasKey('counties', $item);

            $counties = collect($item['list'])->count();

            $this->assertEquals($counties, $item['counties']);
        });
    }

    /** @test */
    public function itListsTheNumberOfEateriesAndBranchesInEachCounty(): void
    {
        $collection = app(GetCountyListAction::class)->handle();

        $collection->each(function (array $item, $country): void {
            $this->assertArrayHasKey('eateries', $item);

            $eateries = EateryCountry::query()
                ->firstWhere('country', $country)
                ->eateries()
                ->withCount(['nationwideBranches'])
                ->get();

            $total = $eateries->count() + $eateries->pluck('nationwide_branches_count')->sum();

            $this->assertEquals($total, $item['eateries']);
        });
    }
}
