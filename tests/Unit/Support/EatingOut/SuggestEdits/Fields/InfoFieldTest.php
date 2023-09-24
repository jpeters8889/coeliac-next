<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\Fields\InfoField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class InfoFieldTest extends TestCase
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
        $field = app(InfoField::class);

        $this->assertEquals('', $field->getCurrentValue($this->eatery));
    }

    /** @test */
    public function itReturnsThePreparedValue(): void
    {
        $field = InfoField::make('Foo');

        $this->assertEquals('Foo', $field->prepare());
    }

    /** @test */
    public function itReturnsTheValueForDisplay(): void
    {
        $field = InfoField::make('Foo');

        $this->assertEquals('Foo', $field->getSuggestedValue());
    }
}
