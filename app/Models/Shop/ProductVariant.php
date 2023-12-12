<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'shop_product_variants';

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope());
    }

    /** @return BelongsTo<Product, self> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
