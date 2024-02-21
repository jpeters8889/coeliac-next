<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

class StripeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->instance(StripeClient::class, new StripeClient(config('services.stripe.secret')));
    }
}
