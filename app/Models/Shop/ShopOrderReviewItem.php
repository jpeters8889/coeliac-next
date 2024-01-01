<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopOrderReviewItem extends Model
{
    protected $casts = [
        'rating' => 'float',
    ];

    /** @return BelongsTo<ShopProduct, self> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    /** @return BelongsTo<ShopOrderReview, self> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ShopOrderReview::class, 'review_id');
    }

    /** @return BelongsTo<ShopOrder, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
