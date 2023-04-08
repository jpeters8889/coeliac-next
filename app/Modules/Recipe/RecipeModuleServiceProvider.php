<?php

declare(strict_types=1);

namespace App\Modules\Recipe;

use App\Modules\Recipe\Providers\RouteServiceProvider;
use App\Providers\ModuleBootstrapperServiceProvider;

class RecipeModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            RouteServiceProvider::class,
        ];
    }
}
