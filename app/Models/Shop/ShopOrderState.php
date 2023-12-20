<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopOrderState extends Model
{
    /** @return HasMany<ShopOrder> */
    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class, 'state_id');
    }
}
