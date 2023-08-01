<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\EateryCounty;
use App\Queries\EatingOut\CountyReviewsQuery;
use App\Resources\EatingOut\CountyEateryResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetTopRatedPlacesInCountyAction
{
    /** @return Collection<int, CountyEateryResource> */
    public function __invoke(EateryCounty $county): Collection
    {
        $key = "wheretoeat_county_{$county->slug}_most_rated_places";

        if(Cache::has($key)) {
            /** @var Collection<int, CountyEateryResource> $cached */
            $cached = Cache::get($key);

            return $cached;
        }

        $places = app(CountyReviewsQuery::class)($county, 'rating desc, rating_count desc');

        Cache::put($key, $places, now()->addDay());

        return $places;
    }
}
