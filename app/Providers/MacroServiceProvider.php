<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Arr::macro('average', function (?array $values) {
            if ( ! $values) {
                return null;
            }

            return round(array_sum($values) / count($values) * 2) / 2;
        });
    }
}
