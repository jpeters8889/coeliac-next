<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Source extends Model
{
    protected $table = 'shop_sources';

    /** @return BelongsToMany<Order> */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shop_order_sources', 'source_id', 'order_id');
    }
}
