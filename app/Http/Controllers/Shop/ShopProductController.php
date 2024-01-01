<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Http\Response\Inertia;
use App\Models\Shop\ShopProduct;
use App\Resources\Shop\ShopProductResource;
use App\Resources\Shop\ShopProductReviewResource;
use Inertia\Response;

class ShopProductController
{
    public function __invoke(ShopProduct $product, Inertia $inertia): Response
    {
        $product->load(['categories', 'prices', 'variants', 'media', 'reviews']);

        $reviews = $product->reviews()
            ->with(['parent'])
            ->latest()
            ->paginate(7);

        return $inertia
            ->title($product->title)
            ->metaDescription($product->meta_description)
            ->metaTags(explode(',', $product->meta_keywords))
            ->metaImage($product->social_image)
            ->render('Shop/Product', [
                'product' => new ShopProductResource($product),
                'reviews' => ShopProductReviewResource::collection($reviews),
            ]);
    }
}
