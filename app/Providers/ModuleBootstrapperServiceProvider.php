<?php

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
        collect($this->providers())->each(function(string $provider) {
            $this->register($provider);
        });
    }
}
