<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;

class ShopBasketTokenMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var Response $response */
        $response = $next($request);

        if ($request->hasCookie('basket_token')) {
            /** @var string $cookie */
            $cookie = $request->cookie('basket_token');

            $response->withCookie(new Cookie(
                'basket_token',
                $cookie,
                now()->addHour(),
            ));
        }

        return $response;
    }
}
