<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Tests\Concerns\CreatesFactories;
use Tests\Concerns\InteractsWithActions;
use Tests\Concerns\SeedsWebsite;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesFactories;
    use InteractsWithActions;
    use RefreshDatabase;
    use SeedsWebsite;

    protected function migrateUsing(): array
    {
        return [
            '--schema-path' => 'database/schema/mysql-schema.dump'
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();
    }

    /** @param class-string<ServiceProvider> $serviceProvider */
    public function assertServiceProviderLoaded(string $serviceProvider): void
    {
        $this->assertArrayHasKey($serviceProvider, $this->app->getLoadedProviders());
    }

    /** @param class-string<ServiceProvider> $serviceProvider */
    public function assertServiceProviderNotLoaded(string $serviceProvider): void
    {
        $this->assertArrayNotHasKey($serviceProvider, $this->app->getLoadedProviders());
    }
}
