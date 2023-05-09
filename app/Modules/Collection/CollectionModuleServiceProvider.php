<?php

declare(strict_types=1);

namespace App\Modules\Collection;

use App\Modules\Collection\Providers\RouteServiceProvider;
use App\Providers\ModuleBootstrapperServiceProvider;

class CollectionModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            RouteServiceProvider::class,
        ];
    }
}
