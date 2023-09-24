<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryFeature;
use App\Support\EatingOut\SuggestEdits\Fields\FeaturesField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class FeaturesFieldTest extends TestCase
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
        $field = app(FeaturesField::class);

        /** @var string $currentValue */
        $currentValue = $field->getCurrentValue($this->eatery);

        $this->assertJson($currentValue);
    }

    /** @test */
    public function itReturnsThePreparedValue(): void
    {
        $field = FeaturesField::make(1);

        $this->assertEquals(1, $field->prepare());
    }

    /** @test */
    public function itReturnsTheValueForDisplay(): void
    {
        $feature = EateryFeature::query()->first();

        $data = [[
            'key' => $feature->id,
            'label' => $feature->feature,
            'selected' => true,
        ]];

        $field = FeaturesField::make($data);

        $this->assertEquals(json_encode($data), $field->getSuggestedValue());
    }
}
