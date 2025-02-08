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
        $key = config('coeliac.cacheable.eating-out.top-rated');

        return Cache::rememberForever($key, fn () => app(MostReviewsInUkQuery::class)('rating desc, rating_count desc'));
    }
}
