<?php

declare(strict_types=1);

namespace Tests\Mocks\TestModule;

use App\Providers\ModuleBootstrapperServiceProvider;

class TestModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            TestEventServiceProvider::class,
            TestRouteServiceProvider::class,
        ];
    }
}
