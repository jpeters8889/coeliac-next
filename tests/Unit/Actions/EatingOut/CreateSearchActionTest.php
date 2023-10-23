<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\CreateSearchAction;
use App\Models\EatingOut\EaterySearchTerm;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class CreateSearchActionTest extends TestCase
{
    /** @test */
    public function itCreatesASearchTermRecord(): void
    {
        $this->assertEmpty(EaterySearchTerm::all());

        $this->callCreateSearchAction('foo');

        $this->assertNotEmpty(EaterySearchTerm::all());
        $this->assertDatabaseHas(EaterySearchTerm::class, ['term' => 'foo']);
    }

    /** @test */
    public function itUsesAnExistingSearchTermIfOneExistsWithTheSameTermAndRange(): void
    {
        $this->create(EaterySearchTerm::class, [
            'term' => 'foo',
            'range' => 5,
        ]);

        $this->assertCount(1, EaterySearchTerm::all());

        $this->callCreateSearchAction('foo', 5);

        $this->assertCount(1, EaterySearchTerm::all());
    }

    /** @test */
    public function itLogsTheSearch(): void
    {
        TestTime::freeze();

        $searchTerm = $this->create(EaterySearchTerm::class, [
            'term' => 'foo',
            'range' => 5,
        ]);

        $updatedAt = $searchTerm->updated_at;

        $this->assertEmpty($searchTerm->searches);

        TestTime::addHour();

        $this->callCreateSearchAction('foo', 5);

        $this->assertCount(1, $searchTerm->refresh()->searches);

        $this->assertNotEquals($updatedAt, $searchTerm->updated_at);
    }

    protected function callCreateSearchAction(string $term, int $range = 2): void
    {
        $this->callAction(CreateSearchAction::class, $term, $range);
    }
}
