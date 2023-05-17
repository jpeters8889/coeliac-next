<?php

declare(strict_types=1);

namespace App\Modules\EatingOut;

use App\Providers\ModuleBootstrapperServiceProvider;

class EateryModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            //            RouteServiceProvider::class,
        ];
    }
}
