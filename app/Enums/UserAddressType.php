<?php

declare(strict_types=1);

namespace App\Enums;

enum UserAddressType: string
{
    case SHIPPING = 'Shipping';
    case BILLING = 'Billing';
}
