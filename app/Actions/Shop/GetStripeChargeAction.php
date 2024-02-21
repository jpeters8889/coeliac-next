<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use Stripe\Charge;
use Stripe\StripeClient;

class GetStripeChargeAction
{
    public function __construct(protected StripeClient $stripeClient)
    {
        //
    }

    public function handle(string $chargeId): Charge
    {
        return $this->stripeClient
            ->charges
            ->retrieve($chargeId, ['expand' => ['balance_transaction']]);
    }
}
