<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\HttpClientServiceProvider;
use App\Providers\NovaServiceProvider;
use App\Providers\StripeServiceProvider;

return [
    AppServiceProvider::class,
    NovaServiceProvider::class,
    HttpClientServiceProvider::class,
    StripeServiceProvider::class,
];
