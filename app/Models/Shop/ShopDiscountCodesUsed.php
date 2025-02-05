<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopDiscountCodesUsed extends Model
{
    protected $table = 'shop_discount_codes_used';

    /** @return BelongsTo<ShopDiscountCode, $this> */
    public function code(): BelongsTo
    {
        return $this->belongsTo(ShopDiscountCode::class, 'discount_id');
    }

    /** @return BelongsTo<ShopOrder, $this> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
