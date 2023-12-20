<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopPostageCountryArea extends Model
{
    /** @return HasMany<ShopPostageCountry> */
    public function countries(): HasMany
    {
        return $this->hasMany(ShopPostageCountry::class, 'postage_area_id');
    }

    /** @return HasMany<ShopPostagePrice> */
    public function postagePrices(): HasMany
    {
        return $this->hasMany(ShopPostagePrice::class, 'postage_country_area_id');
    }
}
