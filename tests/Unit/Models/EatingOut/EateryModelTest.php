<?php

declare(strict_types=1);

namespace Tests\Unit\Models\EatingOut;

use App\DataObjects\EatingOut\LatLng;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCuisine;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryOpeningTimes;
use App\Models\EatingOut\EateryVenueType;
use App\Support\Helpers;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use Tests\TestCase;

class EateryModelTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->build(Eatery::class)
            ->withoutSlug()
            ->has($this->build(EateryFeature::class), 'features')
            ->create([
                'venue_type_id' => EateryVenueType::query()->first()->id,
                'cuisine_id' => EateryCuisine::query()->first()->id,
            ]);
    }

    /** @test */
    public function itCreatesASlug(): void
    {
        $this->assertNotNull($this->eatery->slug);
        $this->assertEquals(Str::slug($this->eatery->name), $this->eatery->slug);
    }

    /** @test */
    public function itHasATown(): void
    {
        $this->assertEquals(1, $this->eatery->town()->count());
    }

    /** @test */
    public function itHasACounty(): void
    {
        $this->assertEquals(1, $this->eatery->county()->count());
    }

    /** @test */
    public function itHasACountry(): void
    {
        $this->assertEquals(1, $this->eatery->country()->count());
    }

    /** @test */
    public function itHasFeatures(): void
    {
        $this->assertEquals(1, $this->eatery->features()->count());
    }

    /** @test */
    public function itHasAVenueType(): void
    {
        $this->assertEquals(1, $this->eatery->venueType()->count());
    }

    /** @test */
    public function itHasACuisineType(): void
    {
        $this->assertEquals(1, $this->eatery->cuisine()->count());
    }

    /** @test */
    public function itCanHaveOpeningTimes(): void
    {
        $this->assertNull($this->eatery->openingTimes);

        $openingTimes = $this->build(EateryOpeningTimes::class)
            ->forEatery($this->eatery)
            ->create();

        $this->assertNotNull($this->eatery->refresh()->openingTimes);
        $this->assertTrue($this->eatery->openingTimes->is($openingTimes));
    }

    /** @test */
    public function itHasAnHasCategoriesScope(): void
    {
        $this->assertInstanceOf(Builder::class, Eatery::query()->hasCategories([]));
    }

    /** @test */
    public function itHasAnHasVenueTypesScope(): void
    {
        $this->assertInstanceOf(Builder::class, Eatery::query()->hasVenueTypes([]));
    }

    /** @test */
    public function itHasAnHasFeaturesScope(): void
    {
        $this->assertInstanceOf(Builder::class, Eatery::query()->hasFeatures([]));
    }

    /** @test */
    public function itHasAStaticBuilderForLatLngSearch(): void
    {
        $latLng = new LatLng(51.1, 0.23);

        $builder = Eatery::algoliaSearchAroundLatLng($latLng);

        $parameters = Arr::get((new ReflectionClosure($builder->callback))->getUseVariables(), 'parameters');

        $this->assertArrayHasKey('aroundLatLng', $parameters);
        $this->assertEquals($latLng->toString(), $parameters['aroundLatLng']);
    }

    /** @test */
    public function itIncludesTheSearchRadiusInTheLatLngSearch(): void
    {
        $latLng = new LatLng(51.1, 0.23);

        $builder = Eatery::algoliaSearchAroundLatLng($latLng, 5);

        $parameters = Arr::get((new ReflectionClosure($builder->callback))->getUseVariables(), 'parameters');

        $this->assertArrayHasKey('aroundRadius', $parameters);
        $this->assertEquals(Helpers::milesToMeters(5), $parameters['aroundRadius']);
    }
}
