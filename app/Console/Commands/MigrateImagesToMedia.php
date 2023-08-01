<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Legacy\Image;
use App\Legacy\ImageAssociations;
use App\Models\Blogs\Blog;
use App\Models\Collections\Collection;
use App\Models\Recipes\Recipe;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class MigrateImagesToMedia extends Command
{
    protected $signature = 'coeliac:migrate-images {module}';

    protected array $modules = [
        'blog' => Blog::class,
        'recipe' => Recipe::class,
        'collection' => Collection::class,
    ];

    protected array $with = [
        'blog' => ['images'],
        'recipe' => ['images'],
        'collection' => ['images'],
    ];

    protected array $handlers = [
        'blog' => 'processBlog',
        'recipe' => 'processRecipe',
        'collection' => 'processCollection',
    ];

    public function handle(): void
    {
        /** @var string $module */
        $module = $this->argument('module');

        if ( ! array_key_exists($module, $this->modules)) {
            $this->error('Module is not valid');

            return;
        }

        if ( ! $this->confirm('Are you sure you want to migrate images')) {
            return;
        }

        /** @var class-string<Model> $model */
        $model = $this->modules[$module];

        $items = $model::query()
            ->with($this->with[$module])
            ->doesntHave('media')
            ->latest()
            ->get();

        $progress = $this->output->createProgressBar($items->count());

        $items->each(fn ($item) => $this->{$this->handlers[$module]}($item, $progress));
    }

    protected function processBlog(Blog $blog, ProgressBar $progress): void
    {
        ImageAssociations::query()->where('imageable_type', 'Coeliac\Modules\Blog\Models\Blog')
            ->update(['imageable_type' => Blog::class]);

        $blog->refresh();

        /** @phpstan-ignore-next-line */
        $blog->addMediaFromUrl($blog->social_legacy_image)->toMediaCollection('social');

        /** @phpstan-ignore-next-line */
        $blog->addMediaFromUrl($blog->main_legacy_image)->toMediaCollection('primary');

        $blog->images()
            ->where('image_category_id', Image::IMAGE_CATEGORY_GENERAL)
            ->get()
            ->each(function (ImageAssociations $image) use ($blog): void {
                $media = $blog->addMediaFromUrl($image->image->image_url)->toMediaCollection('body');

                $contents = Str::of($blog->body)
                    ->when(
                        config('app.env') !== 'production',
                        fn ($str) => $str->replace('https://images.coeliacsanctuary.co.uk', 'https://images-develop.coeliacsanctuary.co.uk')
                    )
                    ->replace($image->image->image_url, $media->getUrl());

                $blog->body = $contents->toString();

                $blog->saveQuietly();
            });

        $progress->advance();
    }

    protected function processRecipe(Recipe $recipe, ProgressBar $progress): void
    {
        ImageAssociations::query()->where('imageable_type', 'Coeliac\Modules\Recipe\Models\Recipe')
            ->update(['imageable_type' => Recipe::class]);

        $recipe->refresh();

        try {
            /** @phpstan-ignore-next-line */
            $recipe->addMediaFromUrl($recipe->social_legacy_image)->toMediaCollection('social');

            /** @phpstan-ignore-next-line */
            $recipe->addMediaFromUrl($recipe->main_legacy_image)->toMediaCollection('primary');

            if ($recipe->square_legacy_image) {
                $recipe->addMediaFromUrl($recipe->square_legacy_image)->toMediaCollection('square');
            }
        } catch (Exception $e) {
            //
        }

        $progress->advance();
    }

    protected function processCollection(Collection $collection, ProgressBar $progress): void
    {
        ImageAssociations::query()->where('imageable_type', 'Coeliac\Modules\Collection\Models\Collection')
            ->update(['imageable_type' => Collection::class]);

        $collection->refresh();

        try {
            /** @phpstan-ignore-next-line */
            $collection->addMediaFromUrl($collection->social_legacy_image)->toMediaCollection('social');

            /** @phpstan-ignore-next-line */
            $collection->addMediaFromUrl($collection->main_legacy_image)->toMediaCollection('primary');
        } catch (Exception $e) {
            //
        }

        $progress->advance();
    }
}
