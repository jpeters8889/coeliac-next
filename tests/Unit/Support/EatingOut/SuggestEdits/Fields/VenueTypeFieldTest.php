<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\Fields\VenueTypeField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class VenueTypeFieldTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itReturnsTheDatabaseValue(): void
    {
        $field = app(VenueTypeField::class);

        $this->assertEquals($this->eatery->venueType->venue_type, $field->getCurrentValue($this->eatery));
    }

    /** @test */
    public function itReturnsThePreparedValue(): void
    {
        $field = VenueTypeField::make(1);

        $this->assertEquals(1, $field->prepare());
    }

    /** @test */
    public function itReturnsTheValueForDisplay(): void
    {
        $venueType = $this->eatery->venueType;

        $field = VenueTypeField::make($venueType->id);

        $this->assertEquals($venueType->venue_type, $field->getSuggestedValue());
    }
}
