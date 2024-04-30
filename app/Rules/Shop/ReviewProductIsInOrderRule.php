<?php

declare(strict_types=1);

namespace App\Rules\Shop;

use App\Models\Shop\ShopOrderReviewInvitation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class ReviewProductIsInOrderRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var int $value */

        /** @var ShopOrderReviewInvitation $invitation */
        $invitation = app(Request::class)->route('invitation');

        /** @var array<int> $products */
        $products = $invitation->order?->items->pluck('product_id')->values()->toArray();

        if ( ! in_array($value, $products, true)) {
            $fail('This product isn\'t in your order');
        }
    }
}
