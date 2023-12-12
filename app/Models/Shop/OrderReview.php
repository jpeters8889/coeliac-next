<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderReview extends Model
{
    protected $table = 'shop_order_reviews';

    /** @return BelongsTo<OrderReviewInvitation, self> */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(OrderReviewInvitation::class, 'invitation_id');
    }

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /** @return HasMany<OrderReviewItem> */
    public function products(): HasMany
    {
        return $this->hasMany(OrderReviewItem::class, 'review_id');
    }
}
