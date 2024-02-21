<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopShippingAddress extends Model
{
    use SoftDeletes;

    /** @return BelongsTo<ShopCustomer, self> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(ShopCustomer::class, 'customer_id');
    }

    /** @return HasMany<ShopOrder> */
    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class, 'shipping_address_id');
    }
}
