<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Shop\TravelCardSearch;

use App\Models\Shop\TravelCardSearchTerm;
use App\Models\Shop\TravelCardSearchTermHistory;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    /** @test */
    public function itErrorsWithoutASearchTerm(): void
    {
        $this->postJson(route('api.shop.travel-card-search.store'))
            ->assertJsonValidationErrorFor('term');
    }

    /** @test */
    public function itCreatesASearchHistoryRecordForTheSearchTerm(): void
    {
        $this->assertDatabaseEmpty(TravelCardSearchTermHistory::class);

        $this->postJson(route('api.shop.travel-card-search.store'), ['term' => 'foo']);

        $this->assertDatabaseHas(TravelCardSearchTermHistory::class, [
            'term' => 'foo',
            'hits' => 1,
        ]);
    }

    /** @test */
    public function itUpdatesTheHitsOnAnExistingSearchTermIfOneExists(): void
    {
        $searchTerm = $this->create(TravelCardSearchTermHistory::class, [
            'term' => 'foo',
            'hits' => 5,
        ]);

        $this->postJson(route('api.shop.travel-card-search.store'), ['term' => 'foo']);

        $this->assertEquals(6, $searchTerm->refresh()->hits);
    }

    /** @test */
    public function itReturnsMatchSearchTerms(): void
    {
        $this->build(TravelCardSearchTerm::class)
            ->count(2)
            ->sequence(
                ['term' => 'foobar', 'type' => 'country'],
                ['term' => 'barfoo', 'type' => 'language'],
                ['term' => 'baz'],
            )
            ->create();

        $this->postJson(route('api.shop.travel-card-search.store'), ['term' => 'foo'])
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data', 2)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) => $json
                            ->where('type', 'country')
                            ->where('term', '<strong>foo</strong>bar')
                            ->etc()
                    )
                    ->has(
                        'data.1',
                        fn (AssertableJson $json) => $json
                            ->where('type', 'language')
                            ->where('term', 'bar<strong>foo</strong>')
                            ->etc()
                    )
            );
    }
}
