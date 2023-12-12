<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostageCountryArea extends Model
{
    public const UK = 1;

    public const EUROPE = 2;

    public const NORTH_AMERICA = 3;

    public const OCEANA = 4;

    protected $table = 'shop_postage_country_areas';

    /** @return HasMany<PostageCountry> */
    public function countries(): HasMany
    {
        return $this->hasMany(PostageCountry::class, 'postage_area_id');
    }

    /** @return HasMany<PostagePrice> */
    public function postagePrices(): HasMany
    {
        return $this->hasMany(PostagePrice::class, 'postage_country_area_id');
    }
}
