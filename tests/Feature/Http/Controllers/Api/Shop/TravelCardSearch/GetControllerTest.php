<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Shop\TravelCardSearch;

use App\Models\Shop\ShopProduct;
use App\Models\Shop\TravelCardSearchTerm;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    /** @test */
    public function itReturnsNotFoundIfTheSearchTermDoesntExist(): void
    {
        $this->getJson(route('api.shop.travel-card-search.get', ['travelCardSearchTerm' => 123]))
            ->assertNotFound();
    }

    /** @test */
    public function itIncrementsTheHitsOfTheSearchTerm(): void
    {
        $searchTerm = $this->create(TravelCardSearchTerm::class, ['hits' => 5]);

        $this->getJson(route('api.shop.travel-card-search.get', $searchTerm));

        $this->assertEquals(6, $searchTerm->refresh()->hits);
    }

    /** @test */
    public function itReturnsTheTypeAndTerm(): void
    {
        $searchTerm = $this->create(TravelCardSearchTerm::class, [
            'term' => 'spain',
            'type' => 'country',
        ]);

        $this->getJson(route('api.shop.travel-card-search.get', $searchTerm))
            ->assertJsonPath('type', 'country')
            ->assertJsonPath('term', 'Spain');
    }

    /** @test */
    public function itReturnsTheProductsLinkedToTheSearchTerm(): void
    {
        /** @var TravelCardSearchTerm $searchTerm */
        $searchTerm = $this->create(TravelCardSearchTerm::class, [
            'term' => 'spain',
            'type' => 'country',
        ]);

        $this->withCategoriesAndProducts(1, then: function () use ($searchTerm): void {
            $searchTerm->products()->attach(ShopProduct::all());
        });

        $this->getJson(route('api.shop.travel-card-search.get', $searchTerm))
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has(
                        'products',
                        2,
                        fn (AssertableJson $json) => $json
                            ->where('title', 'Product 0')
                            ->etc()
                    )
                    ->etc()
            );
    }
}
