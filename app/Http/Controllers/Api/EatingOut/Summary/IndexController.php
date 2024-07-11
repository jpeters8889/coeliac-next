<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\EatingOut\Summary;

use App\Actions\EatingOut\GetEateryStatisticsAction;

class IndexController
{
    public function __invoke(GetEateryStatisticsAction $getEateryStatisticsAction): array
    {
        return $getEateryStatisticsAction->handle()->toArray();
    }
}
