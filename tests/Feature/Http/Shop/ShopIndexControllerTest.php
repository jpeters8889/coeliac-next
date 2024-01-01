<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Shop;

use App\Models\Shop\ShopCategory;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShopIndexControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withCategoriesAndProducts();
    }

    /** @test */
    public function itLoadsTheShopIndexPage(): void
    {
        $this->get(route('shop.index'))->assertOk();
    }

    /** @test */
    public function itReturnsTheCategories(): void
    {
        $this->get(route('shop.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Shop/Index')
                    ->has(
                        'categories',
                        5,
                        fn (Assert $page) => $page->hasAll(['title', 'description', 'image', 'link'])
                    )
                    ->where('categories.0.title', 'Category 0')
                    ->where('categories.1.title', 'Category 1')
                    ->etc()
            );
    }

    /** @test */
    public function itDoesntReturnACategoryThatDoesntHaveAnyLiveProducts(): void
    {
        $this->create(ShopCategory::class, [
            'title' => 'No Products',
        ]);

        $this->get(route('shop.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Shop/Index')
                    ->has(
                        'categories',
                        fn (Assert $page) => $page
                            ->each(fn (Assert $page) => $page
                                ->whereNot('title', 'No Products')
                                ->etc())
                    )
            );
    }
}
