<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopShippingAddress;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<ShopShippingAddress> */
class ShippingAddress extends Resource
{
    /** @var class-string<ShopShippingAddress> */
    public static string $model = ShopShippingAddress::class;

    public static $clickAction = 'view';

    public static $search = ['id', 'line1', 'town', 'postcode'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Line 1')->required(),
            Text::make('Line 2')->nullable(),
            Text::make('Line 3')->nullable(),
            Text::make('Town')->required(),
            Text::make('County')->nullable(),
            Text::make('Postcode')->required(),
        ];
    }

    public function authorizedToView(Request $request): bool
    {
        return true;
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }
}
