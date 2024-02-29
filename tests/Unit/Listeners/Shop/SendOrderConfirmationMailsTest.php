<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Shop;

use App\Events\Shop\OrderPaidEvent;
use App\Listeners\Shop\SendOrderConfirmationMails;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopProduct;
use App\Notifications\Shop\OrderConfirmedNotification;
use App\Support\Helpers;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendOrderConfirmationMailsTest extends TestCase
{
    protected ShopCustomer $customer;

    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withAdminUser();
        $this->seed(ShopScaffoldingSeeder::class);
        $this->withCategoriesAndProducts(1, 1);

        $this->customer = $this->create(ShopCustomer::class);

        $product = ShopProduct::query()
            ->whereHas('media')
            ->firstOrFail();

        $this->order = $this->build(ShopOrder::class)
            ->asPaid($this->customer)
            ->create();

        $this->build(ShopOrderItem::class)
            ->inOrder($this->order)
            ->add($product->variants->first())
            ->create();

        Notification::fake();
        Mail::fake();
    }

    /** @test */
    public function itSendsAConfirmationEmailToTheCustomer(): void
    {
        $event = new OrderPaidEvent($this->order);

        app(SendOrderConfirmationMails::class)->handle($event);

        Notification::assertSentTo($this->customer, OrderConfirmedNotification::class);
    }

    /** @test */
    public function itSendsAnOrderConfirmationEmailToTheAdmin(): void
    {
        $event = new OrderPaidEvent($this->order);

        app(SendOrderConfirmationMails::class)->handle($event);

        Notification::assertSentTo(Helpers::adminUser(), OrderConfirmedNotification::class);
    }
}
