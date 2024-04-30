<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopOrderReviewInvitation;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use Carbon\Carbon;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ReviewMyOrderGetControllerTest extends TestCase
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
        $this->get(route('shop.review-order', ['invitation' => 'foo']))->assertNotFound();
    }

    /** @test */
    public function itErrorsWhenVisitingTheReviewPageDirectly(): void
    {
        $this->get(route('shop.review-order', [$this->invitation]))->assertForbidden();
    }

    /** @test */
    public function itReturnsOkWhenVisitingAValidInvitation(): void
    {
        $this->getSignedLink()->assertOk();
    }

    /** @test */
    public function itLoadsTheInertiaPage(): void
    {
        $this->getSignedLink()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Shop/ReviewMyOrder')
                    ->where('id', (string) $this->order->order_key)
                    ->where('invitation', $this->invitation->id)
                    ->where('name', $this->order->customer->name)
                    ->has('products', 1, fn (Assert $page) => $page->hasAll(['id', 'title', 'image', 'link']))
            );
    }

    /** @test */
    public function itRedirectsToTheThanksPageIfTheInvitationHasAReviewAssociatedWithIt(): void
    {
        $this->invitation->review()->create(['order_id' => $this->order->id, 'name' => 'Foo']);

        $this->getSignedLink()->assertRedirectToRoute('shop.review-order.thanks', $this->invitation);
    }

    protected function getSignedLink(): TestResponse
    {
        return $this->get(resolve(UrlGenerator::class)->temporarySignedRoute(
            'shop.review-order',
            Carbon::now()->addMonths(6),
            [
                'invitation' => $this->invitation,
                'hash' => sha1($this->order->customer->email),
            ]
        ));
    }
}
