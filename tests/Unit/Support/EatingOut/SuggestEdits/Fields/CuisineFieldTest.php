<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\Fields\CuisineField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class CuisineFieldTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    #[Test]
    public function itReturnsTheDatabaseValue(): void
    {
        $field = app(CuisineField::class);

        $this->assertEquals($this->eatery->cuisine->cuisine, $field->getCurrentValue($this->eatery));
    }

    #[Test]
    public function itReturnsThePreparedValue(): void
    {
        $field = CuisineField::make(1);

        $this->assertEquals(1, $field->prepare());
    }

    #[Test]
    public function itReturnsTheValueForDisplay(): void
    {
        $cuisine = $this->eatery->cuisine;

        $field = CuisineField::make($cuisine->id);

        $this->assertEquals($cuisine->cuisine, $field->getSuggestedValue());
    }
}
