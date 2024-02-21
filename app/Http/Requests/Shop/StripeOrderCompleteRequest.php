<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StripeOrderCompleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_intent' => ['required', 'string'],
            'payment_intent_client_secret' => ['required', 'string'],
        ];
    }

    protected function getRedirectUrl()
    {
        return route('shop.index');
    }
}
