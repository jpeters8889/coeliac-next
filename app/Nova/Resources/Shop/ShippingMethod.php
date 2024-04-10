<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopShippingMethod;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

/**
 * @codeCoverageIgnore
 */
class ShippingMethod extends Resource
{
    public static $model = ShopShippingMethod::class;

    public static $title = 'shipping_method';

    public function fields(Request $request): array
    {
        return [
            ID::make(),

            Text::make('Shipping Method'),

            HasMany::make('Products', 'products', Products::class),
        ];
    }
}
