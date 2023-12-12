<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountCodesUsed extends Model
{
    protected $table = 'shop_discount_codes_used';

    /** @return BelongsTo<DiscountCode, self> */
    public function code(): BelongsTo
    {
        return $this->belongsTo(DiscountCode::class, 'code_id');
    }

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
