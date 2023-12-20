<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopShippingMethod extends Model
{
    /** @return HasMany<ShopProduct> */
    public function products(): HasMany
    {
        return $this->hasMany(ShopProduct::class, 'shipping_method_id');
    }

    /** @return HasMany<ShopPostagePrice> */
    public function prices(): HasMany
    {
        return $this->hasMany(ShopPostagePrice::class, 'shipping_method_id');
    }
}
