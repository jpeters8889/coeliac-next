<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\StoreSuggestedEditAction;
use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\Fields\AddressField;
use App\Support\EatingOut\SuggestEdits\SuggestedEditProcessor;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class StoreSuggestedEditActionTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itCreatesASuggestedEditForTheEatery(): void
    {
        $this->assertEmpty($this->eatery->suggestedEdits);

        $this->callAction(StoreSuggestedEditAction::class, $this->eatery, 'address', 'Foo');

        $this->assertNotEmpty($this->eatery->refresh()->suggestedEdits);
    }

    /** @test */
    public function itResolvesTheEditableField(): void
    {
        $this->partialMock(SuggestedEditProcessor::class)
            ->expects('resolveEditableField')
            ->once()
            ->andReturn(AddressField::make('foo'));

        $this->callAction(StoreSuggestedEditAction::class, $this->eatery, 'address', 'Foo');
    }
}
