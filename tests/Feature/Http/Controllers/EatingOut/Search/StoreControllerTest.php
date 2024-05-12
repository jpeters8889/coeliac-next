<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Search;

use App\Actions\EatingOut\CreateSearchAction;
use App\Models\EatingOut\EaterySearchTerm;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    /** @test */
    public function itErrorsWithAnInvalidSearchTermDetails(): void
    {
        $this->submitSearch(term: null)->assertSessionHasErrors('term');
        $this->submitSearch(term: 123)->assertSessionHasErrors('term');
        $this->submitSearch(term: true)->assertSessionHasErrors('term');
        $this->submitSearch(term: 'aa')->assertSessionHasErrors('term'); // to short
    }

    /** @test */
    public function itErrorsWithAnInvalidSearchRangeDetails(): void
    {
        $this->submitSearch(range: null)->assertSessionHasErrors('range');
        $this->submitSearch(range: 'foo')->assertSessionHasErrors('range');
        $this->submitSearch(range: true)->assertSessionHasErrors('range');
        $this->submitSearch(range: 7)->assertSessionHasErrors('range'); // not valid entry
    }

    /** @test */
    public function itCallsTheCreateSearchAction(): void
    {
        $this->expectAction(CreateSearchAction::class);

        $this->submitSearch('foo', 5);

    }

    /** @test */
    public function itRedirectsToTheResultsPage(): void
    {
        $searchTerm = $this->create(EaterySearchTerm::class, [
            'term' => 'foo',
            'range' => 2,
        ]);

        $this->submitSearch('foo')->assertRedirectToRoute('eating-out.search.show', [
            'eaterySearchTerm' => $searchTerm,
        ]);
    }

    protected function submitSearch(mixed $term = null, mixed $range = 2): TestResponse
    {
        return $this->post(route('eating-out.search.create'), [
            'term' => $term,
            'range' => $range,
        ]);
    }
}
