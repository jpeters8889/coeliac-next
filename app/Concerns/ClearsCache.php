<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/*** @mixin Model */
trait ClearsCache
{
    public static function bootClearsCache(): void
    {
        static::saved(function (self $model): void {
            dispatch(function () use ($model): void {
                /** @var string[] $keys */
                $keys = config("coeliac.cacheable.{$model->cacheKey()}");

                foreach ($keys as $key) {
                    if (preg_match('/(.*)\.\{([a-z.]+)}/', $key, $matches)) {
                        $wildcard = $matches[2];
                        $bits = explode('.', $wildcard);
                        $column = array_pop($bits);

                        $record = $model;

                        foreach ($bits as $bit) {
                            $record = $record->$bit;
                        }

                        if ( ! $record) {
                            continue;
                        }

                        $key = str_replace("{{$wildcard}}", $record->$column, $key);

                        Cache::delete($key);

                        continue;
                    }

                    Cache::delete($key);
                }
            });
        });
    }

    abstract protected function cacheKey(): string;
}
