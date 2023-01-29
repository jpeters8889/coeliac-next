<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Legacy\Image;
use App\Legacy\ImageAssociations;
use App\Modules\Blog\Models\Blog;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class MigrateImagesToMedia extends Command
{
    protected $signature = 'coeliac:migrate-images {module}';

    protected array $modules = [
        'blog' => Blog::class,
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

    public function handle()
    {
        if (! array_key_exists($this->argument('module'), $this->modules)) {
            $this->error('Module is not valid');

            return;
        }

        if (! $this->confirm('Are you sure you want to migrate images')) {
            return;
        }

        /** @var class-string<Model> $model */
        $model = $this->modules[$this->argument('module')];

        $items = $model::query()
            ->with($this->with[$this->argument('module')])
            ->latest()
            ->get();

        $progress = $this->output->createProgressBar($items->count());

        $items->each(fn ($item) => $this->{$this->handlers[$this->argument('module')]}($item, $progress));
    }

    protected function processBlog(Blog $blog, ProgressBar $progress): void
    {
        ImageAssociations::query()->where('imageable_type', 'Coeliac\Modules\Blog\Models\Blog')
            ->update(['imageable_type' => Blog::class]);

        $blog->addMediaFromUrl($blog->social_legacy_image)->toMediaCollection('social');

        $blog->addMediaFromUrl($blog->main_legacy_image)->toMediaCollection('primary');

        $blog->images()
            ->where('image_category_id', Image::IMAGE_CATEGORY_GENERAL)
            ->get()
            ->each(function (ImageAssociations $image) use ($blog) {
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
}
