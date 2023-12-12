<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostagePrice extends Model
{
    protected $table = 'shop_postage_prices';

    /** @return BelongsTo<PostageCountryArea, self> */
    public function area(): BelongsTo
    {
        return $this->belongsTo(PostageCountryArea::class, 'postage_country_area_id');
    }

    /** @return BelongsTo<ShippingMethod, self> */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }
}
