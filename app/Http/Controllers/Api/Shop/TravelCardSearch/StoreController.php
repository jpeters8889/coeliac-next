<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Shop\TravelCardSearch;

use App\Http\Requests\Shop\TravelCardSearchRequest;
use App\Models\Shop\TravelCardSearchTerm;
use App\Models\Shop\TravelCardSearchTermHistory;
use Illuminate\Support\Str;

class StoreController
{
    public function __invoke(TravelCardSearchRequest $request): array
    {
        $searchString = $request->string('term')->toString();

        TravelCardSearchTermHistory::query()
            ->firstOrCreate(['term' => $searchString], ['hits' => 0])
            ->increment('hits');

        return [
            'data' => TravelCardSearchTerm::query()
                ->where('term', 'like', "%{$searchString}%")
                ->get()
                ->map(fn (TravelCardSearchTerm $searchTerm) => [
                    'id' => $searchTerm->id,
                    'term' => Str::replace(
                        $searchString,
                        "<strong>{$searchString}</strong>",
                        $searchTerm->term,
                    ),
                    'type' => $searchTerm->type,
                ]),
        ];
    }
}
