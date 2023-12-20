<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductPrice;
use Carbon\Carbon;

class ShopProductPriceFactory extends Factory
{
    protected $model = ShopProductPrice::class;

    public function definition()
    {
        return [
            'product_id' => self::factoryForModel(ShopProduct::class),
            'price' => $this->faker->numberBetween(100, 1500),
            'start_at' => Carbon::now()->subHour(),
            'sale_price' => false,
        ];
    }

    public function forProduct(ShopProduct $product)
    {
        return $this->state(fn () => [
            'product_id' => $product->id,
        ]);
    }

    public function onSale()
    {
        return $this->state(fn () => [
            'sale_price' => true,
        ]);
    }

    public function ended()
    {
        return $this->state(fn () => [
            'end_at' => Carbon::now()->subDay(),
        ]);
    }
}
