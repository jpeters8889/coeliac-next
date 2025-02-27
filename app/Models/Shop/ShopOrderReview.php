<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopOrderReview extends Model
{
    /** @return BelongsTo<ShopOrderReviewInvitation, $this> */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(ShopOrderReviewInvitation::class, 'invitation_id');
    }

    /** @return BelongsTo<ShopOrder, $this> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    /** @return HasMany<ShopOrderReviewItem, $this> */
    public function products(): HasMany
    {
        return $this->hasMany(ShopOrderReviewItem::class, 'review_id');
    }
}
