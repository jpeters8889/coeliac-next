<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\EateryCounty;
use App\Queries\EatingOut\CountyReviewsQuery;
use App\Resources\EatingOut\CountyEateryResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetMostRatedPlacesInCountyAction
{
    /** @return Collection<int, CountyEateryResource> */
    public function handle(EateryCounty $county): Collection
    {
        $key = str_replace('{county.slug}', $county->slug, config('coeliac.cacheable.eating-out.most-rated-in-county'));

        return Cache::rememberForever($key, fn () => app(CountyReviewsQuery::class)($county, 'rating_count desc, rating desc'));
    }
}
