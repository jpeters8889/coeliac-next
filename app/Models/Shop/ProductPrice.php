<?php

declare(strict_types=1);

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    protected $casts = [
        'start_at' => Carbon::class,
        'end_at' => Carbon::class,
    ];

    protected $table = 'shop_product_prices';

    /** @return BelongsTo<Product, self> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
