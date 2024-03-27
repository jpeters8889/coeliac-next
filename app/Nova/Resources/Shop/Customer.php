<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopCustomer;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<ShopCustomer> */
class Customer extends Resource
{
    /** @var class-string<ShopCustomer> */
    public static string $model = ShopCustomer::class;

    public static $clickAction = 'view';

    public static $search = ['id', 'name', 'email'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Name'),

            Email::make('Email'),

            Text::make('Phone')->nullable(),
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
