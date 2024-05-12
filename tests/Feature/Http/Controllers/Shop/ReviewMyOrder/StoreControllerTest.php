<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop\ReviewMyOrder;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewInvitation;
use App\Models\Shop\ShopOrderReviewItem;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use App\Models\Shop\ShopSource;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\ReviewMyOrderRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    protected ShopOrder $order;

    protected ShopProduct $product;

    protected ShopProductVariant $variant;

    protected ShopOrderReviewInvitation $invitation;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);

        $this->withCategoriesAndProducts(1, 1);

        $this->order = $this->build(ShopOrder::class)
            ->asShipped()
            ->create();

        $this->product = ShopProduct::query()->first();
        $this->variant = $this->product->variants->first();

        $this->item = $this->create(ShopOrderItem::class, [
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'product_variant_id' => $this->variant->id,
            'product_price' => 200,
        ]);

        $this->invitation = $this->order->reviewInvitation()->create();
    }

    /** @test */
    public function itReturnsNotFoundForAnInvitationThatDoesntExist(): void
    {
        $this->post(route('shop.review-order.store', ['invitation' => 'foo']))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundIfTheInvitationHasAReviewAssociatedWithIt(): void
    {
        $this->invitation->review()->create(['order_id' => $this->order->id, 'name' => 'Foo']);

        $this->makeRequest()->assertNotFound();
    }

    /** @test */
    public function itAllowsRequestsWithoutAName(): void
    {
        $this->makeRequest(['name' => null])->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsIfARequestHasAnInvalidName(): void
    {
        $this->makeRequest(['name' => 123])->assertSessionHasErrors('name');
    }

    /** @test */
    public function itAllowsRequestsWithoutWhereHeard(): void
    {
        $this->makeRequest(['whereHeard' => null])->assertSessionHasErrors('whereHeard');
    }

    /** @test */
    public function itErrorsWhenWhereHeardIsntAnArray(): void
    {
        $this->makeRequest(['whereHeard' => 123])->assertSessionHasErrors('whereHeard');
    }

    /** @test */
    public function itErrorsWhenWhereHeardIsntAnArrayOfStrings(): void
    {
        $this->makeRequest(['whereHeard' => ['foo', 123]])
            ->assertSessionDoesntHaveErrors('whereHeard.0')
            ->assertSessionHasErrors('whereHeard.1');
    }

    /** @test */
    public function itErrorsWithoutAProductsParameterInTheRequest(): void
    {
        $this->makeRequest(products: collect([]))->assertSessionHasErrors('products');
    }

    /** @test */
    public function itErrorsIfTheProductsParameterIsntAnArray(): void
    {
        $this->makeRequest(['products' => 'foo'])->assertSessionHasErrors('products');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHaveAnId(): void
    {
        $this->makeRequest(['products' => [['review' => 'foo']]])->assertSessionHasErrors('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHasAnInvalidId(): void
    {
        $this->makeRequest(['products' => [['id' => 'foo']]])->assertSessionHasErrors('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductHasAIdThatDoesntExist(): void
    {
        $this->makeRequest(['products' => [['id' => 999]]])->assertSessionHasErrors('products.0.id');
    }

    /** @test */
    public function itErrorsIfTryingToLeaveFeedbackForAnItemNotInTheOrder(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->makeRequest(['products' => [['id' => $product->id]]])->assertSessionHasErrors('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHaveARating(): void
    {
        $this->makeRequest(['products' => [['id' => 1]]])->assertSessionHasErrors('products.0.rating');
    }

    /** @test */
    public function itErrorsIfAProductHasARatingThatIsntNumeric(): void
    {
        $this->makeRequest(['products' => [['rating' => 'foo']]])->assertSessionHasErrors('products.0.rating');
    }

    /** @test */
    public function itErrorsIfAProductsHasARatingThatIsntInTheRange(): void
    {
        $this->makeRequest(['products' => [['rating' => -1]]])->assertSessionHasErrors('products.0.rating');

        $this->makeRequest(['products' => [['rating' => 6]]])->assertSessionHasErrors('products.0.rating');
    }

    /** @test */
    public function itErrorsIfAProductHasAnInvalidReview(): void
    {
        $this->makeRequest(['products' => [['review' => 123]]])->assertSessionHasErrors('products.0.review');
    }

    /** @test */
    public function itAssociatesTheShopSourceWithTheOrder(): void
    {
        $this->assertEmpty($this->order->sources);

        $this->makeRequest();

        $this->assertNotEmpty($this->order->refresh()->sources);
    }

    /** @test */
    public function itCreatesTheShopSourceIfItDoestExist(): void
    {
        $this->assertDatabaseMissing(ShopSource::class, ['source' => 'foobar']);

        $this->makeRequest(['whereHeard' => ['foobar']]);

        $this->assertDatabaseHas(ShopSource::class, ['source' => 'foobar']);
    }

    /** @test */
    public function itCreatesTheReview(): void
    {
        $this->assertDatabaseEmpty(ShopOrderReview::class);

        $this->makeRequest();
        $this->assertDatabaseCount(ShopOrderReview::class, 1);
        $this->assertInstanceOf(ShopOrderReview::class, $this->invitation->review);
    }

    /** @test */
    public function itCreatesAReviewForTheProducts(): void
    {
        $this->assertDatabaseEmpty(ShopOrderReviewItem::class);

        $this->makeRequest();

        $this->assertDatabaseCount(ShopOrderReviewItem::class, 1);
        $this->assertDatabaseHas(ShopOrderReviewItem::class, [
            'product_id' => $this->product->id,
            'order_id' => $this->order->id,
        ]);
    }

    /** @test */
    public function itRedirectsToTheThanksPage(): void
    {
        $this->makeRequest()->assertRedirectToRoute('shop.review-order.thanks', $this->invitation);
    }

    protected function makeRequest(array $params = [], ?Collection $products = null): TestResponse
    {
        $products ??= collect([$this->item]);
        $data = ReviewMyOrderRequestFactory::new($params);

        if ( ! array_key_exists('products', $params)) {
            $data = $data->forProducts($products);
        }

        return $this->post(route('shop.review-order.store', $this->invitation), $data->create($params));
    }
}
