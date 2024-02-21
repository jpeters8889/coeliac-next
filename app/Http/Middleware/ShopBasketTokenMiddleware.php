<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;

class ShopBasketTokenMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var Response | RedirectResponse | JsonResponse $response */
        $response = $next($request);

        if ($this->isBasketDonePage($request, $response)) {
            $response->withoutCookie('basket_token');
            \Illuminate\Support\Facades\Cookie::forget('basket_token');
            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('basket_token'));

            return $response;
        }

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

    protected function isBasketDonePage(Request $request, Response|RedirectResponse|JsonResponse $response): bool
    {
        if ( ! $request->routeIs('shop.basket.done')) {
            return false;
        }

        return $response->status() === Response::HTTP_OK;
    }
}
