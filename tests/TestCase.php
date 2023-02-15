<?php

declare(strict_types=1);

namespace Tests;

use App\Modules\Blog\Models\Blog;
use Carbon\Carbon;
use Database\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as IlluminateFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

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
    }

    /**
     * @template T
     *
     * @param class-string<T> $what
     * @return IlluminateFactory<T>
     */
    protected function build(string $what): IlluminateFactory
    {
        return Factory::factoryForModel($what);
    }

    /**
     * @template T
     *
     * @param class-string<T> $what
     * @param array $attributes
     * @return T
     */
    protected function create(string $what, array $attributes = [])
    {
        return $this->build($what)->create($attributes);
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

    protected function withBlogs($count = 10, callable $then = null): static
    {
        Storage::fake('media');

        $this->build(Blog::class)
            ->count($count)
            ->sequence(fn (Sequence $sequence) => [
                'title' => "Blog {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index)
            ])
            ->create()
            ->each(function (Blog $blog): void {
                $blog->addMedia(UploadedFile::fake()->image('blog.jpg'))->toMediaCollection('primary');
            });

        if ($then) {
            $then();
        }

        return $this;
    }
}
