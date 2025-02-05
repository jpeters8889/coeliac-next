<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ShopCustomer extends Model
{
    use Notifiable;

    /** @return HasMany<ShopShippingAddress, $this> */
    public function addresses(): HasMany
    {
        return $this->hasMany(ShopShippingAddress::class, 'customer_id');
    }
}
