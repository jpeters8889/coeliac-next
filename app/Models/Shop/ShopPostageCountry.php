<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopPostageCountry extends Model
{
    /** @return BelongsTo<ShopPostageCountryArea, $this> */
    public function area(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountryArea::class, 'postage_area_id');
    }

    /** @return HasMany<ShopOrder, $this> */
    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class, 'postage_country_id');
    }
}
