<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class OrderReviewInvitation extends Model
{
    protected $table = 'shop_order_review_invitations';

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted(): void
    {
        self::creating(function (self $invitation) {
            $invitation->id = Str::uuid()->toString();

            return $invitation;
        });
    }

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /** @return HasOne<OrderReview> */
    public function review(): HasOne
    {
        return $this->hasOne(OrderReview::class, 'invitation_id');
    }
}
