<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /** @return Attribute<string, never> */
    public function formattedAddress(): Attribute
    {
        return Attribute::get(function () {
            $keys = ['name', 'line_1', 'line_2', 'line_3', 'town', 'county', 'postcode', 'country'];

            return collect($keys)
                ->map(fn (string $key) => $this->$key)
                ->filter()
                ->join(PHP_EOL);
        });
    }
}
