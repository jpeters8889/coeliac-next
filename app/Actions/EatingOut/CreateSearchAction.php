<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\EaterySearchTerm;

class CreateSearchAction
{
    public function handle(string $term, int $range): EaterySearchTerm
    {
        $searchTerm = EaterySearchTerm::query()->firstOrCreate([
            'term' => $term,
            'range' => $range,
        ]);

        $searchTerm->logSearch();

        return $searchTerm;
    }
}
