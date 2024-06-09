<?php

declare(strict_types=1);

namespace App\DataObjects\Search;

use Illuminate\Support\Collection;

class SearchResultsCollection
{
    /**
     * @param  Collection<int, SearchResultItem>  $blogs
     * @param  Collection<int, SearchResultItem>  $recipes
     * @param  Collection<int, SearchResultItem>  $eateries
     * @param  Collection<int, SearchResultItem>  $shop
     */
    public function __construct(
        readonly public Collection $blogs = new Collection(),
        readonly public Collection $recipes = new Collection(),
        readonly public Collection $eateries = new Collection(),
        readonly public Collection $shop = new Collection(),
    ) {
        //
    }
}
