<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $table = 'shop_shipping_methods';

    /** @return HasMany<Product> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /** @return HasMany<ProductPrice> */
    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'shipping_method_id');
    }
}
