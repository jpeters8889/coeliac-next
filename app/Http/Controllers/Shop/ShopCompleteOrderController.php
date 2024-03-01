<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\CalculateOrderTotalsAction;
use App\Actions\Shop\Checkout\CreateCustomerAction;
use App\Actions\Shop\Checkout\CreateShippingAddressAction;
use App\Actions\Shop\GetOrderItemsAction;
use App\Actions\Shop\ResolveBasketAction;
use App\DataObjects\Shop\PendingOrderCustomerDetails;
use App\DataObjects\Shop\PendingOrderShippingAddressDetails;
use App\Enums\Shop\OrderState;
use App\Http\Requests\Shop\CompleteOrderRequest;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPostageCountry;
use App\Resources\Shop\ShopOrderItemResource;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ShopCompleteOrderController
{
    public function __invoke(
        CompleteOrderRequest $request,
        ResolveBasketAction $resolveBasketAction,
        GetOrderItemsAction $getOrderItemsAction,
        CalculateOrderTotalsAction $calculateOrderTotalsAction,
        CreateCustomerAction $createUserAction,
        CreateShippingAddressAction $createAddressAction,
    ): Response {
        /** @var string $token */
        $token = $request->cookie('basket_token');

        /** @var ShopOrder $basket */
        $basket = $resolveBasketAction->handle($token, false);

        /** @var ShopPostageCountry $country */
        $country = $basket->postageCountry;

        $items = $getOrderItemsAction->handle($basket);

        /** @var Collection<int, ShopOrderItemResource> $collection */
        $collection = $items->collection;

        try {
            DB::beginTransaction();

            $customer = $createUserAction->handle(PendingOrderCustomerDetails::createFromRequest($request));
            $address = $createAddressAction->handle(
                $customer,
                PendingOrderShippingAddressDetails::createFromRequest($request, $country->country),
            );

            $basket->payment()->create([
                ...$calculateOrderTotalsAction->handle($collection, $country),
                'discount' => 0,
            ]);

            $basket->update([
                'customer_id' => $customer->id,
                'shipping_address_id' => $address->id,
                'order_key' => Str::of(Str::password(8, letters: false, symbols: false))->padLeft(8, '0'),
                'state_id' => OrderState::PENDING,
            ]);

            DB::commit();

            return new Response(status: Response::HTTP_CREATED);
        } catch (Exception $exception) {
            dump($exception);
            DB::rollBack();

            throw ValidationException::withMessages(['order' => 'There was an error completing your order, you have not been charged']);
        }
    }
}