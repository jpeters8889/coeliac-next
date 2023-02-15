<?php

declare(strict_types=1);

namespace App\Modules\Shared\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LiveScope implements Scope
{
    /**
     * @template T of Model
     *
     * @param Builder<T> $builder
     * @param T $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @phpstan-ignore-next-line  */
        $builder->where('live', true);
    }
}
