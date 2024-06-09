<?php

declare(strict_types=1);

namespace App\DataObjects\Search;

class SearchPipelineData
{
    public function __construct(
        readonly public SearchParameters $parameters,
        readonly public SearchResultsCollection $results,
    ) {
        //
    }
}
