<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Enums\Shop\DiscountCodeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ShopDiscountCode extends Model
{
    protected $casts = [
        'type_id' => DiscountCodeType::class,
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /** @return BelongsTo<ShopDiscountCodeType, self> */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ShopDiscountCodeType::class, 'type_id');
    }

    /** @return HasManyThrough<ShopOrder> */
    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
            ShopOrder::class,
            ShopDiscountCodesUsed::class,
            'discount_id',
            'id',
            'id',
            'order_id'
        );
    }

    /** @return HasMany<ShopDiscountCodesUsed> */
    public function used(): HasMany
    {
        return $this->hasMany(ShopDiscountCodesUsed::class, 'discount_id');
    }
}
