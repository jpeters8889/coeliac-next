<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use App\Nova\Actions\Shop\CancelOrder;
use App\Nova\Actions\Shop\OpenDispatchSlip;
use App\Nova\Actions\Shop\ShipOrder;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Jpeters8889\CountryIcon\CountryIcon;
use Jpeters8889\ShopOrderOpenDispatchSlip\ShopOrderOpenDispatchSlip;
use Jpeters8889\ShopOrderShippingAction\ShopOrderShippingAction;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<ShopProduct> */
class Orders extends Resource
{
    /** @var class-string<ShopOrder> */
    public static string $model = ShopOrder::class;

    public static $clickAction = 'view';

    public static $search = ['id', 'order_key', 'customer.name', 'address.line_1', 'address.town', 'address.postcode'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Order ID', 'order_key'),

            DateTime::make('Order Date', fn (ShopOrder $order) => $order->payment->created_at),

            Text::make('Address', fn (ShopOrder $order) => nl2br($order->address->formatted_address))->asHtml(),

            Number::make('Items', fn (ShopOrder $order) => $order->items->sum('quantity')),

            Currency::make('Total', fn (ShopOrder $order) => $order->payment->total)->asMinorUnits(),

            Text::make('Payment Method', fn (ShopOrder $order) => $order->payment->payment_type_id),

            Currency::make('Processing Fee', fn (ShopOrder $order) => $order->payment->fee)->asMinorUnits(),

            CountryIcon::make('Country', fn (ShopOrder $order) => [
                'name' => $order->postageCountry->country,
                'code' => $order->postageCountry->iso_code,
            ]),

            ShopOrderShippingAction::make('Shipped', fn (ShopOrder $order) => [
                'parent_id' => $order->id,
                'state_id' => $order->state_id->value,
                'shipped_at' => $order->shipped_at?->format('jS M y'),
            ]),

            ShopOrderOpenDispatchSlip::make('', 'id'),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            CancelOrder::make()
                ->showInline()
                ->canRun(fn ($request, ShopOrder $order) => $order->state_id !== OrderState::SHIPPED),
            OpenDispatchSlip::make()
                ->onlyInline()
                ->withoutConfirmation(),
            ShipOrder::make()
                ->showInline()
                ->withoutConfirmation()
                ->canRun(fn ($request, ShopOrder $order) => $order->state_id === OrderState::READY),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->withoutGlobalScopes()
            ->with(['postageCountry', 'payment', 'address', 'items'])
            ->withCount(['items'])
            ->whereNotIn('state_id', [
                OrderState::BASKET,
                OrderState::PENDING,
                OrderState::EXPIRED,
            ]);
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