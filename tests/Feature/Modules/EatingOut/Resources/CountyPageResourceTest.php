<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\Resources;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use App\Resources\EatingOut\CountyPageResource;
use App\Resources\EatingOut\CountyTownCollection;
use App\Resources\EatingOut\CountyTownResource;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CountyPageResourceTest extends TestCase
{
    protected EateryCounty $county;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();

        Storage::fake('media');
    }

    /** @test */
    public function itReturnsTheCorrectKeys(): void
    {
        $keys = ['name', 'slug', 'image', 'towns', 'eateries', 'reviews'];

        $resource = (new CountyPageResource($this->county))->toArray(request());

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $resource);
        }
    }

    /** @test */
    public function itUsesTheImageAssociatedWithTheCountyIfOneIsSet(): void
    {
        $this->county->addMedia(UploadedFile::fake()->image('county.jpg'))->toMediaCollection('primary');

        $resource = (new CountyPageResource($this->county))->toArray(request());

        $this->assertStringContainsString('county.jpg', $resource['image']);
    }

    /** @test */
    public function itFallsBackToTheGenericCountryImageIfTheCountyDoesntHaveOne(): void
    {
        $resource = (new CountyPageResource($this->county))->toArray(request());

        $this->assertStringContainsString('england.jpg', $resource['image']);
    }

    /** @test */
    public function itListsTheNumberOfEateriesInThatCounty(): void
    {
        $this->build(Eatery::class)
            ->count(5)
            ->create(['county_id' => $this->county->id]);

        $resource = (new CountyPageResource($this->county))->toArray(request());

        $this->assertEquals(5, $resource['eateries']);
    }

    /** @test */
    public function itListsTheNumberOfReviewsInTheCounty(): void
    {
        $this->build(Eatery::class)
            ->count(5)
            ->has($this->build(EateryReview::class)->count(5), 'reviews')
            ->create(['county_id' => $this->county->id]);

        $resource = (new CountyPageResource($this->county))->toArray(request());

        $this->assertEquals(25, $resource['reviews']);
    }

    /** @test */
    public function itReturnsTheTownsAsACollection(): void
    {
        $this->build(EateryTown::class)
            ->count(10)
            ->create(['county_id' => $this->county->id]);

        $resource = (new CountyPageResource($this->county))->toArray(request());

        $this->assertInstanceOf(CountyTownCollection::class, $resource['towns']);
    }

    /** @test */
    public function itReturnsEachTownAsATownResource(): void
    {
        $this->build(EateryTown::class)
            ->count(10)
            ->has($this->build(Eatery::class))
            ->create(['county_id' => $this->county->id]);

        /** @var CountyTownCollection $towns */
        $towns = (new CountyPageResource($this->county))->toArray(request())['towns'];

        $towns->resource->each(fn ($town) => $this->assertInstanceOf(CountyTownResource::class, $town));
    }
}
