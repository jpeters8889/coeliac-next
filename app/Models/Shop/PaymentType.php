<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentType extends Model
{
    protected $table = 'shop_payment_types';

    /** @return HasMany<Payment> */
    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class, 'payment_type_id');
    }
}
