<?php

declare(strict_types=1);

namespace App\Http\Response;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia as BaseInertia;
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

    /**
     * @param string $component
     * @param array|Arrayable<int|string, mixed> $props
     * @return Response
     */
    public function render(string $component, array|Arrayable $props = []): Response
    {
        return BaseInertia::render($component, $props);
    }

    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function getShared(string $key = null, mixed $default = null): mixed
    {
        return BaseInertia::getShared($key, $default);
    }
}
