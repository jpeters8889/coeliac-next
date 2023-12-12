<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    protected $table = 'shop_orders';

    /** @return BelongsTo<OrderState, self> */
    public function state(): BelongsTo
    {
        return $this->belongsTo(OrderState::class, 'state_id');
    }

    /** @return BelongsTo<User, self> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<UserAddress, self> */
    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id')->withTrashed();
    }

    /** @return HasOne<Payment> */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    /** @return HasMany<OrderItem> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /** @return BelongsTo<PostageCountry, self> */
    public function postageCountry(): BelongsTo
    {
        return $this->belongsTo(PostageCountry::class, 'postage_country_id');
    }

    /** @return HasOneThrough<DiscountCode> */
    public function discountCode(): HasOneThrough
    {
        return $this->hasOneThrough(DiscountCode::class, DiscountCodesUsed::class, 'order_id', 'id', 'id', 'discount_id');
    }

    /** @return HasOne<OrderReviewInvitation> */
    public function reviewInvitation(): HasOne
    {
        return $this->hasOne(OrderReviewInvitation::class, 'order_id');
    }

    /** @return HasMany<OrderReview> */
    public function reviews(): HasMany
    {
        return $this->hasMany(OrderReview::class, 'order_id');
    }

    /** @return HasMany<OrderReviewItem> */
    public function reviewedItems(): HasMany
    {
        return $this->hasMany(OrderReviewItem::class, 'order_id');
    }

    /** @return BelongsToMany<Source> */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'shop_order_sources', 'order_id', 'source_id');
    }
}
