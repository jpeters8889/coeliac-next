<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopPostageCountry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class BasketPatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'postage_country_id' => ['nullable', Rule::exists(ShopPostageCountry::class, 'id')],
            'action' => ['nullable', 'in:increase,decrease'],
            'item_id' => ['nullable', 'required_with:action', 'numeric'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->missing('action')) {
                    return;
                }

                $itemInBasket = ShopOrderItem::query()
                    ->where('id', $this->integer('item_id'))
                    ->whereRelation('order', fn (Builder $builder) => $builder
                        ->where('state_id', OrderState::BASKET)
                        ->where('token', $this->cookie('basket_token')))
                    ->exists();

                if ( ! $itemInBasket) {
                    $validator->errors()->add('item_id', "This product isn't in your basket");
                }
            },
        ];
    }
}
