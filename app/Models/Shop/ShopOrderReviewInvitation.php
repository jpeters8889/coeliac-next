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

    protected $casts = [
        'sent' => 'bool',
        'sent_at' => 'datetime',
    ];

    /** @return BelongsTo<ShopOrder, $this> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    /** @return HasOne<ShopOrderReview, $this> */
    public function review(): HasOne
    {
        return $this->hasOne(ShopOrderReview::class, 'invitation_id');
    }
}
