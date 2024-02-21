<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShopHasBasketMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ( ! $request->hasCookie('basket_token')) {
            throw ValidationException::withMessages(['basket' => 'No Basket Found']);
        }

        $check = ShopOrder::query()
            ->where('token', $request->cookie('basket_token'))
            ->where('state_id', OrderState::BASKET)
            ->exists();

        if ( ! $check) {
            throw ValidationException::withMessages(['basket' => 'No Basket Found']);
        }

        return $next($request);
    }
}
