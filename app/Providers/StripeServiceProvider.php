<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

class StripeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var string $stripeKey */
        $stripeKey = config('services.stripe.secret');

        $this->app->instance(StripeClient::class, new StripeClient($stripeKey));
    }
}
