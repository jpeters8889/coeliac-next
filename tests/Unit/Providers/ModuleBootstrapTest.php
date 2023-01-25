<?php

declare(strict_types=1);

namespace Tests\Unit\Providers;

use App\Modules\Shared\SharedModuleServiceProvider;
use App\Providers\ModuleServiceProvider;
use Tests\Mocks\TestModule\TestEventServiceProvider;
use Tests\Mocks\TestModule\TestModuleServiceProvider;
use Tests\Mocks\TestModule\TestRouteServiceProvider;
use Tests\TestCase;

class ModuleBootstrapTest extends TestCase
{
    /** @test */
    public function itRegistersTheModuleBootstrapServices(): void
    {
        $this->assertServiceProviderLoaded(ModuleServiceProvider::class);
    }

    /** @test */
    public function itRegistersProvidersWithinAModuleIntoTheServiceContainer(): void
    {
        $this->assertServiceProviderNotLoaded(TestEventServiceProvider::class);
        $this->assertServiceProviderNotLoaded(TestRouteServiceProvider::class);

        $this->app->register(TestModuleServiceProvider::class);

        $this->assertServiceProviderLoaded(TestEventServiceProvider::class);
        $this->assertServiceProviderLoaded(TestRouteServiceProvider::class);
    }

    /** @test */
    public function itRegistersTheSharedModuleIntoTheServiceContainer(): void
    {
        $this->assertServiceProviderLoaded(SharedModuleServiceProvider::class);
    }
}
