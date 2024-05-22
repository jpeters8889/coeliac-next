<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use App\Models\Blogs\Blog;
use App\Models\Collections\Collection;
use App\Models\Recipes\Recipe;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class PublishItemsCommandTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider publishableModels
     *
     * @param  class-string<Model>  $model
     */
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

    /**
     * @test
     *
     * @dataProvider publishableModels
     *
     * @param  class-string<Model>  $model
     */
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

    /**
     * @test
     *
     * @dataProvider publishableModels
     *
     * @param  class-string<Model>  $model
     */
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
