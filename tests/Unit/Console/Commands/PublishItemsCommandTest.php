<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Blogs\Blog;
use App\Models\Collections\Collection;
use App\Models\Recipes\Recipe;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class PublishItemsCommandTest extends TestCase
{
    /** @param  class-string<Model>  $model */
    #[Test]
    #[DataProvider('publishableModels')]
    public function itPublishesAModel(string $model): void
    {
        /** @var Model $instance */
        $instance = $this->create($model, [
            'live' => false,
            'draft' => false,
            'publish_at' => now()->subMinute(),
        ]);

        $this->artisan('coeliac:publish-items');

        $this->assertTrue($instance->refresh()->live);
    }

    /** @param  class-string<Model>  $model */
    #[Test]
    #[DataProvider('publishableModels')]
    public function itDoesntPublishADraftModel(string $model): void
    {
        /** @var Model $instance */
        $instance = $this->create($model, [
            'live' => false,
            'draft' => true,
            'publish_at' => now()->subMinute(),
        ]);

        $this->artisan('coeliac:publish-items');

        $this->assertFalse($instance->refresh()->live);
    }

    /** @param  class-string<Model>  $model */
    #[Test]
    #[DataProvider('publishableModels')]
    public function itDoesntPublishAModelWithAFuturePublishAt(string $model): void
    {
        /** @var Model $instance */
        $instance = $this->create($model, [
            'live' => false,
            'draft' => false,
            'publish_at' => now()->addDay(),
        ]);

        $this->artisan('coeliac:publish-items');

        $this->assertFalse($instance->refresh()->live);
    }

    public static function publishableModels(): array
    {
        return [
            'Blogs' => [Blog::class],
            'Recipes' => [Recipe::class],
            'Collection' => [Collection::class],
        ];
    }
}
