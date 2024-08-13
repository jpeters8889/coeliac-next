<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Contracts\OpenGraphActionContract;
use App\Models\EatingOut\EateryCounty;
use Illuminate\View\View;

class GenerateCountyOpenGraphImageAction implements OpenGraphActionContract
{
    /** @param EateryCounty $model */
    public function handle(HasOpenGraphImageContract $model): View
    {
        $model->loadMissing(['media', 'country']);

        $towns = $model->activeTowns()->count();
        $eateries = $model->eateries()->count() + $model->nationwideBranches()->count();
        $reviews = $model->reviews()->count();

        return view('og-images.eating-out.county', [
            'county' => $model,
            'towns' => $towns,
            'eateries' => $eateries,
            'reviews' => $reviews,
        ]);
    }
}
