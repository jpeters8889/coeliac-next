<?php

declare(strict_types=1);

namespace App\Rules\Shop;

use App\Actions\Shop\ResolveBasketAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPostcodeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( ! request()->hasCookie('basket_token')) {
            return;
        }

        /** @var string $basketToken */
        $basketToken = request()->cookie('basket_token');

        $basket = app(ResolveBasketAction::class)->handle($basketToken, false);

        if ( ! $basket || $basket->postage_country_id !== 1) {
            return;
        }

        $match = preg_match('/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i', $value);

        if ( ! $match) {
            $fail('Invalid Postcode');
        }
    }
}
