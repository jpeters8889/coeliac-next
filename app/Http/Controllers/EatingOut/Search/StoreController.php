<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\Search;

use App\Actions\EatingOut\CreateSearchAction;
use App\Http\Requests\EatingOut\SearchCreateRequest;
use Illuminate\Http\RedirectResponse;

class StoreController
{
    public function __invoke(SearchCreateRequest $request, CreateSearchAction $createSearchAction): RedirectResponse
    {
        $searchTerm = $createSearchAction->handle($request->string('term')->toString(), $request->integer('range'));

        return new RedirectResponse(route('eating-out.search.show', ['eaterySearchTerm' => $searchTerm]));
    }
}
