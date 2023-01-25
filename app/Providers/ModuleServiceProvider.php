<?php

declare(strict_types=1);

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
        collect($this->modules)->each(function (string $module): void {
            $this->app->register($module);
        });
    }
}
