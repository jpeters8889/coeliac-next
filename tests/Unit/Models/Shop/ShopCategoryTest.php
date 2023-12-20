<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ShopCategoryTest extends TestCase
{
    /** @test */
    public function itHasALiveScope(): void
    {
        $this->assertNotEmpty(ShopCategory::query()->toBase()->wheres);
    }

    /** @test */
    public function itCanHaveMedia(): void
    {
        $category = $this->create(ShopCategory::class);

        $category->addMedia(UploadedFile::fake()->image('social.jpg'))->toMediaCollection('social');
        $category->addMedia(UploadedFile::fake()->image('primary.jpg'))->toMediaCollection('primary');

        $this->assertCount(2, $category->media);
    }

    /** @test */
    public function itCanGenerateALink(): void
    {
        $category = $this->create(ShopCategory::class, [
            'slug' => 'test-category',
        ]);

        $this->assertEquals('/shop/test-category', $category->link);
    }

    /** @test */
    public function itHasManyProducts(): void
    {
        ShopCategory::withoutGlobalScopes();
        ShopProduct::withoutGlobalScopes();
        ShopProductVariant::withoutGlobalScopes();

        $category = $this->create(ShopCategory::class);

        $products = $this->build(ShopProduct::class)
            ->count(5)
            ->create();

        $category->products()->attach($products->pluck('id')->toArray());

        $this->assertCount(5, $category->products()->withoutGlobalScopes()->get());
    }
}