<?php

declare(strict_types=1);

namespace App\Http\Response;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia as BaseInertia;
use Inertia\LazyProp;
use Inertia\Response;

class Inertia
{
    public function __construct()
    {
        BaseInertia::share('meta.title', config('metas.title'));
        BaseInertia::share('meta.description', config('metas.description'));
        BaseInertia::share('meta.tags', config('metas.tags'));
        BaseInertia::share('meta.image', config('metas.image'));
    }

    public function title(string $title): self
    {
        BaseInertia::share('meta.title', $title);

        return $this;
    }

    public function metaDescription(string $description): self
    {
        BaseInertia::share('meta.description', $description);

        return $this;
    }

    public function metaTags(array $tags, bool $merge = true): self
    {
        if ($merge) {
            /** @var string[] $defaultTags */
            $defaultTags = config('metas.tags');

            $tags = array_merge($tags, $defaultTags);
        }

        BaseInertia::share('meta.tags', $tags);

        return $this;
    }

    public function metaImage(string $image): self
    {
        BaseInertia::share('meta.image', $image);

        return $this;
    }

    public function schema(string $schema): self
    {
        BaseInertia::share('meta.schema', $schema);

        return $this;
    }

    public function alternateMetas(array $metas): self
    {
        BaseInertia::share('meta.alternateMetas', $metas);

        return $this;
    }

    public function doNotTrack(): self
    {
        BaseInertia::share('meta.doNotTrack', true);

        return $this;
    }

    /**
     * @param  array|Arrayable<int|string, mixed>  $props
     */
    public function render(string $component, array|Arrayable $props = []): Response
    {
        return BaseInertia::render($component, $props);
    }

    public function getShared(string $key = null, mixed $default = null): mixed
    {
        return BaseInertia::getShared($key, $default);
    }

    public function lazy(callable $callback): LazyProp
    {
        return BaseInertia::lazy($callback);
    }
}
