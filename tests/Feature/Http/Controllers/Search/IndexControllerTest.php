<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Search;

use App\Models\Search\SearchHistory;
use App\Pipelines\Search\PerformSearchPipeline;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itCreatesASearchHistoryRecordIfOneDoesntExist(): void
    {
        $this->assertDatabaseEmpty(SearchHistory::class);

        $this->get(route('search.index', ['q' => 'foo']));

        $this->assertDatabaseCount(SearchHistory::class, 1);
        $this->assertEquals('foo', SearchHistory::query()->first()->term);
    }

    /** @test */
    public function itIncrementsTheSearchHistoryIfOneIsFound(): void
    {
        /** @var SearchHistory $searchHistory */
        $searchHistory = $this->create(SearchHistory::class, [
            'term' => 'foo',
            'number_of_searches' => 5,
        ]);

        $this->get(route('search.index', ['q' => 'foo']));

        $this->assertDatabaseCount(SearchHistory::class, 1);
        $this->assertEquals(6, $searchHistory->refresh()->number_of_searches);
    }

    /** @test */
    public function itCallsThePerformSearchPipeline(): void
    {
        $this->expectPipelineToRun(PerformSearchPipeline::class);

        $this->get(route('search.index', ['q' => 'foo']));
    }

    /** @test */
    public function itReturnsTheInertiaView(): void
    {
        $this->get(route('search.index', [
            'q' => 'foo',
            'blogs' => 'true',
            'recipes' => 'false',
            'eateries' => 'true',
            'shop' => 'false',
        ]))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Search/Index')
                    ->has(
                        'parameters',
                        fn (Assert $page) => $page
                            ->where('q', 'foo')
                            ->where('blogs', true)
                            ->where('recipes', false)
                            ->where('eateries', true)
                            ->where('shop', false),
                    )
                    ->has('results')
            );
    }
}
