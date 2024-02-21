<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\GetPaymentIntentAction;
use App\Actions\Shop\GetStripeChargeAction;
use App\Actions\Shop\MarkOrderAsPaidAction;
use App\Enums\Shop\OrderState;
use App\Events\Shop\OrderPaidEvent;
use App\Http\Requests\Shop\StripeOrderCompleteRequest;
use App\Http\Response\Inertia;
use App\Models\Shop\ShopOrder;
use App\Resources\Shop\ShopOrderCompleteResource;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Inertia\Response;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

class ShopOrderCompleteController
{
    public function __invoke(
        StripeOrderCompleteRequest $request,
        Inertia $inertia,
        GetPaymentIntentAction $getPaymentIntentAction,
        GetStripeChargeAction $getStripeChargeAction,
        MarkOrderAsPaidAction $markOrderAsPaidAction,
    ): Response|RedirectResponse {
        try {
            $pendingOrder = ShopOrder::query()
                ->where('payment_intent_id', $request->string('payment_intent_client_secret')->toString())
                ->where('state_id', OrderState::PENDING)
                ->firstOrFail();

            $paymentIntentResponse = $getPaymentIntentAction->handle($request->string('payment_intent')->toString());

            if ($paymentIntentResponse->status !== PaymentIntent::STATUS_SUCCEEDED) {
                $pendingOrder->update(['state_id' => OrderState::BASKET]);

                return redirect(route('shop.basket.checkout'))
                    ->withErrors(['basket' => 'There has an error authorising your payment, you have not been charged, please try again.'])
                    ->withCookie('basket_token', $pendingOrder->token);
            }

            $charge = $getStripeChargeAction->handle((string) $paymentIntentResponse->latest_charge);

            /** @var PaymentMethod $paymentMethod */
            $paymentMethod = PaymentMethod::constructFrom($charge->payment_method_details?->toArray() ?? []);

            $markOrderAsPaidAction->handle($pendingOrder, $charge);

            OrderPaidEvent::dispatch($pendingOrder);

            $pendingOrder->load(['items', 'items.product', 'items.variant', 'payment', 'address']);

            Cookie::forget('basket_token');

            return $inertia
                ->title('Order Complete!')
                ->doNotTrack()
                ->render('Shop/OrderComplete', [
                    'order' => new ShopOrderCompleteResource($pendingOrder, $paymentMethod),
                ]);
        } catch (Exception $exception) {
            return new RedirectResponse(route('shop.index'));
        }
    }
}
