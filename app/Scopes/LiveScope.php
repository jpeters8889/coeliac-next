<?php

declare(strict_types=1);

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LiveScope implements Scope
{
    public function __construct(protected string $field = 'live')
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
        $builder->where($this->field, true);
    }
}
