<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostageCountry extends Model
{
    public const UK = 1;

    public const ROI = 2;

    public const USA = 18;

    public const AUS = 20;

    protected $table = 'shop_postage_countries';

    /** @return BelongsTo<PostageCountryArea, self> */
    public function area(): BelongsTo
    {
        return $this->belongsTo(PostageCountryArea::class, 'postage_area_id');
    }

    /** @return HasMany<Order> */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'postage_country_id');
    }
}
