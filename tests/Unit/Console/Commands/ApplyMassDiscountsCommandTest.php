<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\ApplyMassDiscountsCommand;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopMassDiscount;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductPrice;
use Carbon\Carbon;
use Tests\TestCase;

class ApplyMassDiscountsCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withCategoriesAndProducts();
    }

    /** @test */
    public function itDoesntDoAnythingIfThereAreNoMassDiscountsToProcess(): void
    {
        $count = ShopProductPrice::query()->count();

        $this->artisan(ApplyMassDiscountsCommand::class);

        $this->assertDatabaseCount(ShopProductPrice::class, $count);
    }

    /** @test */
    public function itDoesntProcessMassDiscountsWithAStartDateInTheFuture(): void
    {
        $this->create(ShopMassDiscount::class, [
            'start_at' => Carbon::now()->addWeek(),
        ]);

        $count = ShopProductPrice::query()->count();

        $this->artisan(ApplyMassDiscountsCommand::class);

        $this->assertDatabaseCount(ShopProductPrice::class, $count);
    }

    /** @test */
    public function itCreatesASalePriceForEachProductInACategoryLinkedToAMassDiscount(): void
    {
        $category = ShopCategory::query()->first();

        $this->build(ShopMassDiscount::class)
            ->forCategory($category)
            ->create([
                'start_at' => Carbon::now()->subMinute(),
            ]);

        $category->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));

        $this->artisan(ApplyMassDiscountsCommand::class);

        $category->products()->each(function (ShopProduct $product): void {
            $this->assertCount(2, $product->prices);
            $this->assertCount(1, $product->prices->where('sale_price', true));
        });
    }

    /** @test */
    public function itDoesntCreateASalePriceForProductsInAnotherCategory(): void
    {
        $category = ShopCategory::query()->first();
        $otherCategory = ShopCategory::query()->where('id', '!=', $category->id)->first();

        $this->build(ShopMassDiscount::class)
            ->forCategory($category)
            ->create([
                'start_at' => Carbon::now()->subMinute(),
            ]);

        $category->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));
        $otherCategory->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));

        $this->artisan(ApplyMassDiscountsCommand::class);

        $category->products()->each(fn (ShopProduct $product) => $this->assertCount(2, $product->prices));
        $otherCategory->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));
    }

    /** @test */
    public function itDoesntProcessMassDiscountsThatHaveAlreadyBeenProcessed(): void
    {
        $category = ShopCategory::query()->first();

        $this->build(ShopMassDiscount::class)
            ->forCategory($category)
            ->alreadyProcessed()
            ->create([
                'start_at' => Carbon::now()->subMinute(),
            ]);

        $category->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));

        $this->artisan(ApplyMassDiscountsCommand::class);

        $category->products()->each(fn (ShopProduct $product) => $this->assertCount(1, $product->prices));
    }
}
