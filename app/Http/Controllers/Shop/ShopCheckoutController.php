<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\CalculateOrderPostageAction;
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
        CalculateOrderPostageAction $calculateOrderPostageAction,
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

            /** @var int $subtotal */
            $subtotal = $collection->map(fn (ShopOrderItemResource $item) => $item->product_price * $item->quantity)->sum();

            $postage = $calculateOrderPostageAction->handle($collection, $country);

            $total = $subtotal + $postage;

            $props = [
                'has_basket' => true,
                'countries' => ShopPostageCountry::query()
                    ->orderBy('country')
                    ->get()
                    ->map(fn (ShopPostageCountry $postageCountry) => [
                        'value' => $postageCountry->id,
                        'label' => $postageCountry->country,
                    ]),
                'basket' => [
                    'items' => $items,
                    'selected_country' => $basket->postage_country_id,
                    'delivery_timescale' => $basket->postageCountry?->area?->delivery_timescale,
                    'subtotal' => Helpers::formatMoney(Money::GBP($subtotal)),
                    'postage' => Helpers::formatMoney(Money::GBP($postage)),
                    'total' => Helpers::formatMoney(Money::GBP($total)),
                ],
            ];
        }

        return $inertia
            ->title('Checkout')
            ->doNotTrack()
            ->render('Shop/Checkout', $props);
    }
}
