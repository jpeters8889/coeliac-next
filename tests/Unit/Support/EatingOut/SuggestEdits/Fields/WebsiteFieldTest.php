<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\Fields\WebsiteField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class WebsiteFieldTest extends TestCase
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
        $field = app(WebsiteField::class);

        $this->assertEquals($this->eatery->website, $field->getCurrentValue($this->eatery));
    }

    /** @test */
    public function itReturnsThePreparedValue(): void
    {
        $field = WebsiteField::make('Foo');

        $this->assertEquals('Foo', $field->prepare());
    }

    /** @test */
    public function itReturnsTheValueForDisplay(): void
    {
        $field = WebsiteField::make('Foo');

        $this->assertEquals('Foo', $field->getSuggestedValue());
    }
}
