<?php

declare(strict_types=1);

namespace App\Modules\Shared;

use App\Modules\Shared\Providers\RouteServiceProvider;
use App\Providers\ModuleBootstrapperServiceProvider;

class SharedModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            RouteServiceProvider::class,
        ];
    }
}
