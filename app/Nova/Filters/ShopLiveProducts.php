<?php

declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Shop\ShopProduct;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ShopLiveProducts extends BooleanFilter
{
    public $name = 'Live';

    /** @var Builder<ShopProduct> */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereRelation(
            'variants',
            fn (Builder $builder) => $builder
                ->withoutGlobalScopes()
                ->where(
                    fn (Builder $builder) => $builder
                        ->when($value['live'], fn (Builder $builder) => $builder->orWhere('live', true))
                        ->when($value['not-live'], fn (Builder $builder) => $builder->orWhere('live', false))
                )
        );
    }

    public function default()
    {
        return [
            'live' => true,
            'not-live' => false,
        ];

    }

    public function options(NovaRequest $request)
    {
        return [
            'Live' => 'live',
            'Not Live' => 'not-live',
        ];
    }
}
