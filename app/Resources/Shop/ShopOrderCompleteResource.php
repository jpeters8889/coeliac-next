<?php

declare(strict_types=1);

namespace App\Resources\Shop;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPayment;
use App\Models\Shop\ShopShippingAddress;
use App\Support\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Money\Money;
use Stripe\Card;
use Stripe\PaymentMethod;

/** @mixin ShopOrder */
class ShopOrderCompleteResource extends JsonResource
{
    public function __construct($resource, protected PaymentMethod $paymentMethod)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        /** @var ShopPayment $payment */
        $payment = $this->payment;

        /** @var ShopShippingAddress $shipping */
        $shipping = $this->address;

        return [
            'id' => $this->order_key,
            'products' => ShopOrderItemResource::collection($this->items),
            'subtotal' => Helpers::formatMoney(Money::GBP($payment->subtotal)),
            'postage' => Helpers::formatMoney(Money::GBP($payment->postage)),
            'total' => Helpers::formatMoney(Money::GBP($payment->total)),
            'shipping' => array_filter([
                $shipping->name,
                $shipping->line_1,
                $shipping->line_2,
                $shipping->line_3,
                $shipping->town,
                $shipping->county,
                $shipping->postcode,
                $shipping->country,
            ]),
            'payment' => $this->getPaymentDetails($payment->payment_type_id),
        ];
    }

    protected function getPaymentDetails(string $paymentType): array
    {
        $base = ['type' => $paymentType];

        if ($paymentType === 'Card') {
            /** @var Card $card */
            $card = $this->paymentMethod->card;

            $base = [
                ...$base,
                'lastDigits' => $card->last4,
                'expiry' => Str::of((string) $card->exp_month)->padLeft(2, '0')
                    ->append(' / ')
                    ->append(Str::of((string) $card->exp_year)->reverse()->take(2)->reverse()->toString()),
            ];
        }

        if ($paymentType === 'PayPal') {
            /** @var object{payer_email: string} $paypal */
            $paypal = $this->paymentMethod->paypal;

            $base = [
                ...$base,
                'paypalAccount' => $paypal->payer_email,
            ];
        }

        return $base;
    }
}
