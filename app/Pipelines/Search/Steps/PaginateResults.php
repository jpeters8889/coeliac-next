<?php

declare(strict_types=1);

namespace App\Pipelines\Search\Steps;

use App\DataObjects\Search\SearchResultItem;
use Closure;
use Illuminate\Support\Collection;

class PaginateResults
{
    /**
     * @param  Collection<int, SearchResultItem>  $results
     */
    public function handle(Collection $results, Closure $next): mixed
    {
        $results = $results->paginate()->withQueryString();

        return $next($results);
    }
}
