<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopPostagePrice extends Model
{
    /** @return BelongsTo<ShopPostageCountryArea, $this> */
    public function area(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountryArea::class, 'postage_country_area_id');
    }

    /** @return BelongsTo<ShopShippingMethod, $this> */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShopShippingMethod::class, 'shipping_method_id');
    }
}
