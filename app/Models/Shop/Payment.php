<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $table = 'shop_payments';

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /** @return BelongsTo<PaymentType, self> */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    /** @return HasOne<PaymentResponse> */
    public function response(): HasOne
    {
        return $this->hasOne(PaymentResponse::class, 'payment_id');
    }
}
