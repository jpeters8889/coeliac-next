<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopFeedback;
use App\Models\Shop\ShopOrderReviewItem;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductPrice;
use App\Models\Shop\ShopProductVariant;
use App\Models\Shop\ShopShippingMethod;
use App\Models\Shop\TravelCardSearchTerm;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasALiveScope(): void
    {
        $this->assertNotEmpty(ShopProduct::query()->toBase()->wheres);
    }

    /** @test */
    public function itCanHaveMedia(): void
    {
        $product = $this->create(ShopProduct::class);

        $product->addMedia(UploadedFile::fake()->image('social.jpg'))->toMediaCollection('social');
        $product->addMedia(UploadedFile::fake()->image('primary.jpg'))->toMediaCollection('primary');

        $this->assertCount(2, $product->media);
    }

    /** @test */
    public function itCanGenerateALink(): void
    {
        $product = $this->create(ShopProduct::class, [
            'slug' => 'test-product',
        ]);

        $this->assertEquals('/shop/product/test-product', $product->link);
    }

    /** @test */
    public function itHasManyCategories(): void
    {
        ShopCategory::withoutGlobalScopes();
        ShopProduct::withoutGlobalScopes();
        ShopProductVariant::withoutGlobalScopes();

        $categories = $this->build(ShopCategory::class)
            ->count(5)
            ->create();

        $product = $this->create(ShopProduct::class);

        $product->categories()->attach($categories->pluck('id')->toArray());

        $this->assertCount(5, $product->categories()->withoutGlobalScopes()->get());
    }

    /** @test */
    public function itHasAShippingMethod(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->assertInstanceOf(ShopShippingMethod::class, $product->shippingMethod);
    }

    /** @test */
    public function itHasManyVariants(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductVariant::class)
            ->count(5)
            ->belongsToProduct($product)
            ->create();

        $this->assertInstanceOf(Collection::class, $product->refresh()->variants);
    }

    /** @test */
    public function itHasManyPrices(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->count(5)
            ->forProduct($product)
            ->create();

        $this->assertInstanceOf(Collection::class, $product->refresh()->prices);
    }

    /** @test */
    public function itHasFeedback(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopFeedback::class)
            ->count(5)
            ->forProduct($product)
            ->create();

        $this->assertInstanceOf(Collection::class, $product->refresh()->feedback);
    }

    /** @test */
    public function itHasReviews(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopOrderReviewItem::class)
            ->count(5)
            ->forProduct($product)
            ->create();

        $this->assertInstanceOf(Collection::class, $product->refresh()->reviews);
    }

    /** @test */
    public function itHasSearchTerms(): void
    {
        $product = $this->create(ShopProduct::class);

        $searchTerms = $this->build(TravelCardSearchTerm::class)
            ->count(5)
            ->create();

        $product->travelCardSearchTerms()->attach($searchTerms);

        $this->assertInstanceOf(Collection::class, $product->refresh()->travelCardSearchTerms);
    }

    /** @test */
    public function itCanGetACollectionOfCurrentPrices(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->ended()
            ->create();

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create();

        $this->assertCount(1, $product->currentPrices());
    }

    /** @test */
    public function itCanGetTheCurrentPrice(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->ended()
            ->create([
                'price' => 200,
            ]);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 100,
            ]);

        $this->assertEquals(100, $product->currentPrice);
    }

    /** @test */
    public function itReturnsTheOldPrice(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->onSale()
            ->create([
                'price' => 100,
            ]);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 200,
            ]);

        $this->assertEquals(200, $product->oldPrice);
    }

    /** @test */
    public function itReturnsTheOldPriceAsNullIfNotOnSale(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 100,
            ]);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 200,
            ]);

        $this->assertNull($product->oldPrice);
    }

    /** @test */
    public function itReturnsAPriceObject(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->onSale()
            ->create([
                'price' => 100,
            ]);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 200,
            ]);

        $this->assertEquals(['current_price' => '£1.00', 'old_price' => '£2.00'], $product->price);
    }

    /** @test */
    public function itReturnsAPriceObjectWithoutAnOldPrice(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 100,
            ]);

        $this->build(ShopProductPrice::class)
            ->forProduct($product)
            ->create([
                'price' => 200,
            ]);

        $this->assertEquals(['current_price' => '£1.00'], $product->price);
    }
}
