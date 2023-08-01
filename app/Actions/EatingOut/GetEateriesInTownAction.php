<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryTown;
use App\Resources\EatingOut\EateryListCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class GetEateriesInTownAction
{
    public function __invoke(EateryTown $town, array $filters = []): EateryListCollection
    {
        /** @var Builder<Eatery> $query */
        $query = $town->liveEateries()
            ->with([
                'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'restaurants',
                'reviews' => fn (HasMany $builder) => $builder
                    ->select(['id', 'wheretoeat_id', 'rating'])
                    ->where('approved', 1)
                    ->latest()
            ])
            ->orderBy('name');

        if (Arr::has($filters, 'categories') && $filters['categories'] !== null) {
            $query = $query->hasCategories($filters['categories']);
        }

        if (Arr::has($filters, 'venueTypes') && $filters['venueTypes'] !== null) {
            $query = $query->hasVenueTypes($filters['venueTypes']);
        }

        if (Arr::has($filters, 'features') && $filters['features'] !== null) {
            $query = $query->hasFeatures($filters['features']);
        }

        return new EateryListCollection($query
            ->paginate(5)
            ->withQueryString());
    }
}
