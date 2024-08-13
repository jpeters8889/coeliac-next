<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Contracts\OpenGraphActionContract;
use App\Models\EatingOut\Eatery;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\View;

class GenerateEateryOpenGraphImageAction implements OpenGraphActionContract
{
    /** @param Eatery $model */
    public function handle(HasOpenGraphImageContract $model): View
    {
        $model->loadMissing(['town', 'county', 'country', 'reviews', 'reviewImages' => fn (Relation $builder) => $builder->getQuery()->latest()])
            ->loadCount(['nationwideBranches']);

        return view('og-images.eating-out.eatery', [
            'eatery' => $model,
        ]);
    }
}
