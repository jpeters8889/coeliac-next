<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Queries\EatingOut\MostReviewsInUkQuery;
use App\Resources\EatingOut\CountyEateryResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetMostRatedPlacesAction
{
    /** @return Collection<int, CountyEateryResource> */
    public function handle(): Collection
    {
        $key = config('coeliac.cacheable.eating-out.most-rated');

        return Cache::rememberForever($key, fn () => app(MostReviewsInUkQuery::class)('rating_count desc, rating desc'));
    }
}
