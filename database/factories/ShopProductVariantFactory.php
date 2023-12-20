<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;

class ShopProductVariantFactory extends Factory
{
    protected $model = ShopProductVariant::class;

    public function definition()
    {
        return [
            'live' => true,
            'title' => $this->faker->words(3, true),
            'weight' => $this->faker->numberBetween(1, 20),
            'quantity' => $this->faker->numberBetween(1, 500),
            'product_id' => self::factoryForModel(ShopProduct::class),
        ];
    }

    public function belongsToProduct(ShopProduct $product): self
    {
        return $this->state(fn () => [
            'product_id' => $product->id,
        ]);
    }

    public function notLive(): self
    {
        return $this->state(fn () => ['live' => false]);
    }

    public function outOfStock(): self
    {
        return $this->state(fn () => ['quantity' => 0]);
    }
}
