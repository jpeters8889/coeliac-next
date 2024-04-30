<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Rules\Shop\ReviewProductIsInOrderRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewMyOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'whereHeard' => ['array'],
            'whereHeard.*' => ['string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'int', 'bail', 'exists:shop_products,id', new ReviewProductIsInOrderRule()],
            'products.*.rating' => ['required', 'numeric', Rule::in(range(1, 5))],
            'products.*.review' => ['string', 'nullable'],
        ];
    }
}
