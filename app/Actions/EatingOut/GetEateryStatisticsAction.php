<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\DataObjects\EatingOut\EateryStatistics;
use App\Enums\EatingOut\EateryType;
use App\Models\EatingOut\Eatery;
use Illuminate\Support\Facades\Cache;

class GetEateryStatisticsAction
{
    public function handle(): EateryStatistics
    {
        $key = config('coeliac.cacheable.eating-out.stats');

        return Cache::rememberForever($key, function () {
            $data = Eatery::query()
                ->select(['id', 'type_id'])
                ->withCount('reviews')
                ->get();

            /** @var int $reviews */
            $reviews = $data->sum('reviews_count');

            return new EateryStatistics(
                total: $data->count(),
                eateries: $data->where('type_id', EateryType::EATERY->value)->count(),
                attractions: $data->where('type_id', EateryType::ATTRACTION->value)->count(),
                hotels: $data->where('type_id', EateryType::HOTEL->value)->count(),
                reviews: $reviews,
            );
        });
    }
}
