<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopPaymentType extends Model
{
    /** @return HasMany<ShopPayment, $this> */
    public function payment(): HasMany
    {
        return $this->hasMany(ShopPayment::class, 'payment_type_id');
    }
}
