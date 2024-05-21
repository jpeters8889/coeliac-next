<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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

        /** @return Collection<int, string> */
        Str::macro('explode', function (string $str, string $separator = ' '): Collection {
            /**
             * @var non-empty-string $str
             * @var non-empty-string $separator
             */
            return collect(explode($separator, $str));
        });
    }
}
