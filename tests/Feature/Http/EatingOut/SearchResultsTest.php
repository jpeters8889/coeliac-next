<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\Http;

use App\Actions\EatingOut\GetFiltersForEateriesAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EaterySearchTerm;
use App\Pipelines\EatingOut\GetSearchResultsPipeline;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SearchResultsTest extends TestCase
{
    protected EaterySearchTerm $eaterySearchTerm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();

        $this->create(Eatery::class);

        $this->eaterySearchTerm = $this->create(EaterySearchTerm::class, ['term' => 'London']);
    }

    /** @test */
    public function itReturnsNotFoundForASearchTermThatDoesntExist(): void
    {
        $this->get(route('eating-out.search.show', ['eaterySearchTerm' => 'foo']))->assertNotFound();
    }

    protected function visitSearchResults(): TestResponse
    {
        return $this->get(route('eating-out.search.show', ['eaterySearchTerm' => $this->eaterySearchTerm->key]));
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->visitSearchResults()->assertOk();
    }

    /** @test */
    public function itCallsTheGetEateriesInSearchAreaAction(): void
    {
        $this->expectPipelineToRun(GetSearchResultsPipeline::class);

        $this->visitSearchResults();
    }

    /** @test */
    public function itCallsTheGetFiltersAction(): void
    {
        $this->expectAction(GetFiltersForEateriesAction::class);

        $this->visitSearchResults();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitSearchResults()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('EatingOut/SearchResults')
                    ->etc()
            );
    }
}
