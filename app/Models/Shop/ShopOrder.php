<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Enums\Shop\OrderState;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;

class ShopOrder extends Model
{
    protected $casts = [
        'state_id' => OrderState::class,
    ];

    protected static function booted(): void
    {
        self::creating(function (self $order): void {
            if ($order->state_id === null) {
                $order->state_id = OrderState::BASKET;
            }

            if ( ! $order->postage_country_id) {
                $order->postage_country_id = 1;
            }

            $order->token = Str::random(8);
        });
    }

    /** @return BelongsTo<ShopOrderState, self> */
    public function state(): BelongsTo
    {
        return $this->belongsTo(ShopOrderState::class, 'state_id');
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

    /** @return HasOne<ShopPayment> */
    public function payment(): HasOne
    {
        return $this->hasOne(ShopPayment::class, 'order_id');
    }

    /** @return HasMany<ShopOrderItem> */
    public function items(): HasMany
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id');
    }

    /** @return BelongsTo<ShopPostageCountry, self> */
    public function postageCountry(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountry::class, 'postage_country_id');
    }

    /** @return HasOneThrough<ShopDiscountCode> */
    public function discountCode(): HasOneThrough
    {
        return $this->hasOneThrough(ShopDiscountCode::class, ShopDiscountCodesUsed::class, 'order_id', 'id', 'id', 'discount_id');
    }

    /** @return HasOne<ShopOrderReviewInvitation> */
    public function reviewInvitation(): HasOne
    {
        return $this->hasOne(ShopOrderReviewInvitation::class, 'order_id');
    }

    /** @return HasMany<ShopOrderReview> */
    public function reviews(): HasMany
    {
        return $this->hasMany(ShopOrderReview::class, 'order_id');
    }

    /** @return HasMany<ShopOrderReviewItem> */
    public function reviewedItems(): HasMany
    {
        return $this->hasMany(ShopOrderReviewItem::class, 'order_id');
    }

    /** @return BelongsToMany<ShopSource> */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(ShopSource::class, 'shop_order_sources', 'order_id', 'source_id');
    }
}
