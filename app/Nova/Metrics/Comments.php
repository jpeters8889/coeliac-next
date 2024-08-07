<?php

declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\Comments\Comment;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class Comments extends Value
{
    public $icon = 'chat-alt';

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result(Comment::query()->withoutGlobalScopes()->where('approved', false)->count());
    }

    public function name()
    {
        return 'New Comments';
    }
}
