<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property ShopProduct $product */
class ShopFeedback extends Model
{
    /** @return BelongsTo<ShopProduct, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }
}
