<?php

declare(strict_types=1);

namespace App\Scopes;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LiveScope implements Scope
{
    public function __construct(protected string|Closure $field = 'live')
    {
        //
    }

    /**
     * @template T of Model
     *
     * @param  Builder<T>  $builder
     */
    public function apply(Builder $builder, Model $model): void
    {
        if ($this->field instanceof Closure) {
            $builder->where(fn (Builder $builder) => call_user_func($this->field, $builder));

            return;
        }

        $builder->where($this->field, true);
    }
}
