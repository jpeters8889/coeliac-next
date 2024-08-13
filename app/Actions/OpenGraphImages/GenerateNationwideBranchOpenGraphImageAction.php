<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Contracts\OpenGraphActionContract;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\View\View;

class GenerateNationwideBranchOpenGraphImageAction implements OpenGraphActionContract
{
    /** @param NationwideBranch $model */
    public function handle(HasOpenGraphImageContract $model): View
    {
        $model->loadMissing(['town', 'county', 'country', 'reviews']);

        return view('og-images.eating-out.eatery', [
            'eatery' => $model,
        ]);
    }
}
