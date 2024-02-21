<?php

declare(strict_types=1);

namespace App\Actions\Shop\Checkout;

use App\DataObjects\Shop\PendingOrderCustomerDetails;
use App\Models\Shop\ShopCustomer;

class CreateCustomerAction
{
    public function handle(PendingOrderCustomerDetails $customerDetails): ShopCustomer
    {
        $customer = ShopCustomer::query()->firstOrNew(['email' => $customerDetails->email]);

        $customer->name = $customerDetails->name;
        $customer->phone = $customerDetails->phone;

        $customer->save();

        return $customer;
    }
}
