<?php

declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\EatingOut\EateryReview;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class Ratings extends Value
{
    public $icon = 'star';

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result(EateryReview::query()->withoutGlobalScopes()->where('approved', false)->count());
    }

    public function name()
    {
        return 'New Eatery Reviews';
    }
}
