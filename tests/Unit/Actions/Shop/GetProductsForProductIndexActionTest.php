<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Actions\Shop\GetProductsForProductIndexAction;
use App\Models\Blogs\Blog;
use App\Models\Shop\ShopProduct;
use App\Resources\Shop\ShopProductApiCollection;
use App\Resources\Shop\ShopProductApiResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetProductsForProductIndexActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withCategoriesAndProducts(1, 15);
    }

    /** @test */
    public function itReturnsAShopProductApiCollection(): void
    {
        $this->assertInstanceOf(
            ShopProductApiCollection::class,
            $this->callAction(GetProductsForProductIndexAction::class),
        );
    }

    /** @test */
    public function itIsAPaginatedCollection(): void
    {
        $blogs = $this->callAction(GetProductsForProductIndexAction::class);

        $this->assertInstanceOf(LengthAwarePaginator::class, $blogs->resource);
    }

    /** @test */
    public function itReturns12ItemsPerPageByDefault(): void
    {
        $this->assertCount(12, $this->callAction(GetProductsForProductIndexAction::class));
    }

    /** @test */
    public function itCanHaveADifferentPageLimitSpecified(): void
    {
        $this->assertCount(5, $this->callAction(GetProductsForProductIndexAction::class, perPage: 5));
    }

    /** @test */
    public function eachItemInThePageIsAShopProductApiResource(): void
    {
        $resource = $this->callAction(GetProductsForProductIndexAction::class)->resource->first();

        $this->assertInstanceOf(ShopProductApiResource::class, $resource);
    }

    /** @test */
    public function itLoadsTheMediaAndPricesRelationship(): void
    {
        /** @var ShopProduct $product */
        $product = $this->callAction(GetProductsForProductIndexAction::class)->resource->first()->resource;

        $this->assertTrue($product->relationLoaded('media'));
        $this->assertTrue($product->relationLoaded('prices'));
    }

    /** @test */
    public function itCanBeFilteredBySearch(): void
    {
        ShopProduct::query()->first()->update(['title' => 'Test Product Yay']);

        $collection = $this->callAction(GetProductsForProductIndexAction::class, search: 'test product');

        $this->assertCount(1, $collection);
    }
}
