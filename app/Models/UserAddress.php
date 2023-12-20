<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Shop\ShopOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    /** @return BelongsTo<User, self> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return HasMany<ShopOrder> */
    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class, 'user_address_id');
    }
}
