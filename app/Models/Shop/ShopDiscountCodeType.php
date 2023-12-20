<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopDiscountCodeType extends Model
{
    protected $table = 'shop_discount_code_types';

    /** @return HasMany<ShopDiscountCode> */
    public function codes(): HasMany
    {
        return $this->hasMany(ShopDiscountCode::class, 'type_id');
    }
}
