<?php

declare(strict_types=1);

namespace App\Http\Response;

use Inertia\ResponseFactory;

class Inertia extends ResponseFactory
{
    public function __construct()
    {
        $this->share('meta.title', config('metas.title'));
        $this->share('meta.description', config('metas.description'));
        $this->share('meta.tags', config('metas.tags'));
        $this->share('meta.image', config('metas.image'));
    }

    public function title(string $title): self
    {
        $this->share('meta.title', $title);

        return $this;
    }

    public function metaDescription(string $description): self
    {
        $this->share('meta.description', $description);

        return $this;
    }

    public function metaTags(array $tags, bool $merge = true): self
    {
        if ($merge) {
            /** @var string[] $defaultTags */
            $defaultTags = config('meta.tags');

            $tags = array_merge($tags, $defaultTags);
        }

        $this->share('meta.tags', $tags);

        return $this;
    }

    public function metaImage(string $image): self
    {
        $this->share('meta.image', $image);

        return $this;
    }
}
