<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopCustomer extends Model
{
    /** @return HasMany<ShopShippingAddress> */
    public function addresses(): HasMany
    {
        return $this->hasMany(ShopShippingAddress::class, 'customer_id');
    }
}
