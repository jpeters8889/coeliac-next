<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Models;

use App\Modules\EatingOut\Models\Eatery;
use App\Modules\EatingOut\Models\EateryFeature;
use App\Modules\EatingOut\Models\EateryOpeningTimes;
use Illuminate\Support\Str;
use Tests\TestCase;

class EateryModelTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->build(Eatery::class)
            ->withoutSlug()
            ->has($this->build(EateryFeature::class), 'features')
            ->create();
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
}
