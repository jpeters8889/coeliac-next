<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopProductPrice;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;

class ProductPrice extends Resource
{
    public static $model = ShopProductPrice::class;

    public static $searchable = false;

    public function fields(Request $request): array
    {
        return [
            ID::make()->fullWidth()->hide(),

            Currency::make('Price')
                ->asMinorUnits()
                ->fullWidth(),

            Boolean::make('Sale Price')->fullWidth(),

            Date::make('Start At')->fullWidth()->default(fn () => now()),

            Date::make('End At')->fullWidth()->nullable(),
        ];
    }
}
