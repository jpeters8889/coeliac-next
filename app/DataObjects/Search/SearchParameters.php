<?php

declare(strict_types=1);

namespace App\DataObjects\Search;

use App\Http\Requests\Search\SearchRequest;

class SearchParameters
{
    public function __construct(
        readonly public string $term,
        readonly public bool $blogs = true,
        readonly public bool $recipes = true,
        readonly public bool $eateries = false,
        readonly public bool $shop = true,
    ) {
        //
    }

    public static function fromRequest(SearchRequest $request): self
    {
        return new self(
            $request->string('q')->toString(),
            $request->boolean('blogs'),
            $request->boolean('recipes'),
            $request->boolean('eateries'),
            $request->boolean('shop'),
        );
    }
}
