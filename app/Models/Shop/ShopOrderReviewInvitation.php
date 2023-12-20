<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShopOrderReviewInvitation extends Model
{
    use HasUuids;

    /** @return BelongsTo<ShopOrder, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    /** @return HasOne<ShopOrderReview> */
    public function review(): HasOne
    {
        return $this->hasOne(ShopOrderReview::class, 'invitation_id');
    }
}
