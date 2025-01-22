<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop\Product;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    protected ShopProduct $product;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withCategoriesAndProducts(1, 1, 2);

        $this->product = ShopProduct::query()->first();
    }

    #[Test]
    public function itReturnsNotFoundIfTheProductDoesntExist(): void
    {
        $this->get(route('shop.product', ['product' => 'foo']))->assertNotFound();
    }

    #[Test]
    public function itReturnsNotFoundIfTheProductDoesntHaveAnyLiveVariants(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->get(route('shop.product', ['product' => $product->slug]))->assertNotFound();
    }

    #[Test]
    public function itReturnsOk(): void
    {
        $this->makeRequest()->assertOk();
    }

    #[Test]
    public function itRendersTheShopProductPage(): void
    {
        $this->makeRequest()->assertInertia(fn (Assert $page) => $page->component('Shop/Product'));
    }

    #[Test]
    public function itReturnsTheProductInformation(): void
    {
        $this->makeRequest()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Shop/Product')
                    ->has('product', fn (Assert $page) => $page->hasAll([
                        'id', 'title', 'description', 'long_description', 'image', 'prices', 'rating', 'variants', 'category', 'variant_title',
                    ]))
            );
    }

    #[Test]
    public function itReturnsTheVariantsInTheProduct(): void
    {
        $this->makeRequest()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Shop/Product')
                    ->has(
                        'product.variants',
                        2,
                    )
                    ->where('product.variants.0.title', 'Variant 0')
                    ->where('product.variants.1.title', 'Variant 1')
                    ->etc()
            );
    }

    public function makeRequest(): TestResponse
    {
        return $this->get(route('shop.product', ['product' => $this->product->slug]));
    }
}
