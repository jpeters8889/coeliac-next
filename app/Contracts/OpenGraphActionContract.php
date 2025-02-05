<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\View\View;

interface OpenGraphActionContract
{
    public function handle(Eatery|NationwideBranch|EateryTown|EateryCounty|EateryCountry $model): View;
}
