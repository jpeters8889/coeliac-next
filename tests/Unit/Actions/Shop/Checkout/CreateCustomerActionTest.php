<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop\Checkout;

use App\Actions\Shop\Checkout\CreateCustomerAction;
use App\DataObjects\Shop\PendingOrderCustomerDetails;
use App\Models\Shop\ShopCustomer;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCustomerActionTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function itCreatesAUser(): void
    {
        $this->assertDatabaseEmpty(ShopCustomer::class);

        $payload = new PendingOrderCustomerDetails(
            name: 'Coeliac Sanctuary',
            email: 'test@coeliacsanctuary.co.uk',
        );

        app(CreateCustomerAction::class)->handle($payload);

        $this->assertDatabaseHas(ShopCustomer::class, get_object_vars($payload));
    }

    /** @test */
    public function itMatchesOntoAnExistingShopCustomerWithTheEmailAddress(): void
    {
        $payload = new PendingOrderCustomerDetails(
            name: 'Coeliac Sanctuary',
            email: 'test@coeliacsanctuary.co.uk',
        );

        $this->create(ShopCustomer::class, ['email' => $payload->email]);

        app(CreateCustomerAction::class)->handle($payload);

        $this->assertDatabaseCount(ShopCustomer::class, 1);
    }

    /** @test */
    public function itUpdatesAStoredShopCustomersDetailsToTheNewDetails(): void
    {
        $payload = new PendingOrderCustomerDetails(
            name: 'Coeliac Sanctuary',
            email: 'test@coeliacsanctuary.co.uk',
            phone: '07123456789'
        );

        /** @var ShopCustomer $user */
        $user = $this->create(ShopCustomer::class, ['email' => $payload->email, 'name' => 'foobar']);

        app(CreateCustomerAction::class)->handle($payload);

        $user->refresh();

        $this->assertEquals($payload->name, $user->name);
        $this->assertEquals($payload->phone, $user->phone);
    }
}
