<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\CalculateOrderTotalsAction;
use App\Actions\Shop\CreatePaymentIntentAction;
use App\Actions\Shop\GetOrderItemsAction;
use App\Actions\Shop\ResolveBasketAction;
use App\Http\Response\Inertia;
use App\Models\Shop\ShopPostageCountry;
use App\Resources\Shop\ShopOrderItemResource;
use App\Support\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Response;
use Money\Money;

class ShopCheckoutController
{
    public function __invoke(
        Inertia $inertia,
        Request $request,
        ResolveBasketAction $resolveBasketAction,
        GetOrderItemsAction $getOrderItemsAction,
        CalculateOrderTotalsAction $calculateOrderTotalsAction,
    ): Response {
        /** @var string | null $token */
        $token = $request->cookies->get('basket_token');
        $basket = $resolveBasketAction->handle($token, false);

        $props = [
            'has_basket' => false,
        ];

        if ($basket && $basket->items()->count() > 0) {
            $basket->touch();

            /** @var ShopPostageCountry $country */
            $country = $basket->postageCountry;

            $items = $getOrderItemsAction->handle($basket);

            /** @var Collection<int, ShopOrderItemResource> $collection */
            $collection = $items->collection;

            ['subtotal' => $subtotal, 'postage' => $postage, 'total' => $total] = $calculateOrderTotalsAction->handle($collection, $country);

            $props = [
                'has_basket' => true,
                'countries' => fn () => ShopPostageCountry::query()
                    ->orderBy('country')
                    ->get()
                    ->map(fn (ShopPostageCountry $postageCountry) => [
                        'value' => $postageCountry->id,
                        'label' => $postageCountry->country,
                    ]),
                'basket' => fn () => [
                    'items' => $items,
                    'selected_country' => $basket->postage_country_id,
                    'delivery_timescale' => $basket->postageCountry?->area?->delivery_timescale,
                    'subtotal' => Helpers::formatMoney(Money::GBP($subtotal)),
                    'postage' => Helpers::formatMoney(Money::GBP($postage)),
                    'total' => Helpers::formatMoney(Money::GBP($total)),
                ],
                'payment_intent' => fn () => app(CreatePaymentIntentAction::class)->handle($basket, $total),
            ];
        }

        return $inertia
            ->title('Checkout')
            ->doNotTrack()
            ->render('Shop/Checkout', $props);
    }
}
