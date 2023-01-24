<?php

namespace Tests\Unit;

use App\Modules\Shared\SharedModuleServiceProvider;
use App\Providers\ModuleServiceProvider;
use Tests\TestCase;

class ModuleBootstrapTest extends TestCase
{
    /** @test */
    public function itRegistersTheModuleBootstrapServices(): void
    {
        $this->assertServiceProviderLoaded(ModuleServiceProvider::class);
    }

    /** @test */
    public function itRegistersProvidersWithinAModule(): void
    {
        // create a mock module provider

        // register it into the service container

        // assert that the providers in that mock have been registered into the container
    }

    /** @test */
    public function itRegistersTheSharedModule(): void
    {
        $this->assertServiceProviderLoaded(SharedModuleServiceProvider::class);
    }
}
