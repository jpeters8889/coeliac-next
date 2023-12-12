<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCodeType extends Model
{
    public const PERCENTAGE = 1;

    public const MONEY = 2;

    protected $table = 'shop_discount_code_types';

    /** @return HasMany<DiscountCode> */
    public function codes(): HasMany
    {
        return $this->hasMany(DiscountCode::class, 'type_id');
    }
}
