<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Queries\EatingOut\MostReviewsInUkQuery;
use App\Resources\EatingOut\CountyEateryResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetTopRatedPlacesAction
{
    /** @return Collection<int, CountyEateryResource> */
    public function handle(): Collection
    {
        $key = 'wheretoeat_top_rated_places';

        if (Cache::has($key)) {
            /** @var Collection<int, CountyEateryResource> $cached */
            $cached = Cache::get($key);

            return $cached;
        }

        $places = app(MostReviewsInUkQuery::class)('rating desc, rating_count desc');

        Cache::put($key, $places, now()->addDay());

        return $places;
    }
}
