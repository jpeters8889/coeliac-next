<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderState extends Model
{
    protected $table = 'shop_order_states';

    public const STATE_BASKET = 1;

    public const STATE_PAID = 2;

    public const STATE_PRINTED = 3;

    public const STATE_SHIPPED = 4;

    public const STATE_COMPLETE = 5;

    public const STATE_REFUNDED = 6;

    public const STATE_CANCELLED = 7;

    public const STATE_EXPIRED = 8;

    /** @return HasMany<Order> */
    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'state_id');
    }
}
