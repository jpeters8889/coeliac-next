<?php

namespace App\Providers;

use App\Modules\Shared\SharedModuleServiceProvider;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /** @var class-string<ModuleBootstrapperServiceProvider>[] */
    protected array $modules = [
        SharedModuleServiceProvider::class,
    ];

    public function boot(): void
    {
        collect($this->modules)->each(function (string $module) {
            $this->app->register($module);
        });
    }
}
