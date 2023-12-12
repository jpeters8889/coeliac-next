<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DiscountCode extends Model
{
    protected $table = 'shop_discount_codes';

    /** @return BelongsTo<DiscountCodeType, self> */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DiscountCodeType::class, 'type_id');
    }

    /** @return HasManyThrough<Order> */
    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
            Order::class,
            DiscountCodesUsed::class,
            'discount_id',
            'id',
            'id',
            'order_id'
        );
    }

    /** @return HasMany<DiscountCodesUsed> */
    protected function used(): HasMany
    {
        return $this->hasMany(DiscountCodesUsed::class, 'discount_id');
    }
}
