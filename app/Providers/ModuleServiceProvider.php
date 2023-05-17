<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Blog\BlogModuleServiceProvider;
use App\Modules\Collection\CollectionModuleServiceProvider;
use App\Modules\EatingOut\EateryModuleServiceProvider;
use App\Modules\Recipe\RecipeModuleServiceProvider;
use App\Modules\Shared\SharedModuleServiceProvider;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /** @var class-string<ModuleBootstrapperServiceProvider>[] */
    protected array $modules = [
        SharedModuleServiceProvider::class,

        BlogModuleServiceProvider::class,
        CollectionModuleServiceProvider::class,
        EateryModuleServiceProvider::class,
        RecipeModuleServiceProvider::class,
    ];

    public function boot(): void
    {
        collect($this->modules)->each(function (string $module): void {
            $this->app->register($module);
        });
    }
}
