<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

abstract class ModuleBootstrapperServiceProvider extends ServiceProvider
{
    /** @return class-string<ServiceProvider>[] */
    public function providers(): array
    {
        return [];
    }

    public function boot(): void
    {
        collect($this->providers())->each(function (string $provider): void {
            $this->app->register($provider);
        });
    }
}
