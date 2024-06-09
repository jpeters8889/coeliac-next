<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Search\Steps;

use App\DataObjects\Search\SearchParameters;
use App\DataObjects\Search\SearchPipelineData;
use App\DataObjects\Search\SearchResultsCollection;
use App\Models\Shop\ShopProduct;
use App\Pipelines\Search\Steps\SearchShop;
use Tests\TestCase;

class SearchShopTest extends TestCase
{
    /** @test */
    public function itDoesntSearchAnyShopProductsIfTheShopProductSearchParameterIsFalse(): void
    {
        $this->create(ShopProduct::class, ['title' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            shop: false,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data): void {
            $this->assertEmpty($data->results->shop);
        };

        app(SearchShop::class)->handle($pipelineData, $closure);
    }

    /** @test */
    public function itSearchesShopProducts(): void
    {
        $this->withCategoriesAndProducts(1, 1);

        /** @var ShopProduct $product */
        $product = ShopProduct::query()->first();

        $product->update(['title' => 'foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            shop: true,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data) use ($product): void {
            $this->assertNotEmpty($data->results->shop);
            $this->assertEquals($product->id, $data->results->shop->first()->id);
        };

        app(SearchShop::class)->handle($pipelineData, $closure);
    }
}
