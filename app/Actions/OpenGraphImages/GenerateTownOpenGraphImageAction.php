<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Contracts\OpenGraphActionContract;
use App\Enums\EatingOut\EateryType;
use App\Models\EatingOut\EateryTown;
use Illuminate\View\View;

class GenerateTownOpenGraphImageAction implements OpenGraphActionContract
{
    /** @param EateryTown $model */
    public function handle(HasOpenGraphImageContract $model): View
    {
        $model->loadMissing(['media', 'county', 'county.media', 'county.country']);

        $eateries = $model->liveEateries()->where('type_id', EateryType::EATERY)->count() + $model->liveBranches()->count();
        $attractions = $model->liveEateries()->where('type_id', EateryType::ATTRACTION)->count();
        $hotels = $model->liveEateries()->where('type_id', EateryType::HOTEL)->count();
        $reviews = $model->reviews()->count();

        $width = max(collect([$eateries, $attractions, $hotels, $reviews])->filter()->count(), 2);

        return view('og-images.eating-out.town', [
            'town' => $model,
            'eateries' => $eateries,
            'attractions' => $attractions,
            'hotels' => $hotels,
            'reviews' => $reviews,
            'width' => $width,
        ]);
    }
}
