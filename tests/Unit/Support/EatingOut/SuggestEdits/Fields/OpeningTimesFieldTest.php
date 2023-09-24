<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryOpeningTimes;
use App\Support\EatingOut\SuggestEdits\Fields\OpeningTimesField;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class OpeningTimesFieldTest extends TestCase
{
    protected Eatery $eatery;

    protected EateryOpeningTimes $eateryOpeningTimes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);

        $this->openingTimes = $this->create(EateryOpeningTimes::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    /** @test */
    public function itReturnsTheDatabaseValue(): void
    {
        $field = app(OpeningTimesField::class);

        /** @var string $currentValue */
        $currentValue = $field->getCurrentValue($this->eatery);

        $this->assertJson($currentValue);

        $data = json_decode($currentValue, true);

        $this->assertArrayHasKeys(['key', 'label', 'closed', 'start', 'end'], $data[0]);
    }

    /** @test */
    public function itReturnsThePreparedValue(): void
    {
        $field = OpeningTimesField::make(1);

        $this->assertEquals(1, $field->prepare());
    }

    /** @test */
    public function itReturnsTheValueForDisplay(): void
    {
        $data = [[
            'key' => 'monday',
            'label' => 'Monday',
            'start' => [11, 30],
            'end' => [22, 30],
        ]];

        $field = OpeningTimesField::make($data);

        $this->assertEquals(json_encode($data), $field->getSuggestedValue());
    }
}
