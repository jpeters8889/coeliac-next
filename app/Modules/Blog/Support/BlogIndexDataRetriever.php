<?php

declare(strict_types=1);

namespace App\Modules\Blog\Support;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Blog\Resources\BlogListCollection;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BlogIndexDataRetriever
{
    protected BlogTag | null $tag = null;

    public function setTag(?BlogTag $tag): self
    {
        if ($tag) {
            $this->tag = $tag;
        }

        return $this;
    }

    /** @return array{blogs: Closure, tags: Closure, activeTag: string | null} */
    public function getData(): array
    {
        return [
            'blogs' => fn () => $this->getBlogs(),
            'tags' => fn () => $this->getTags(),
            'activeTag' => $this->tag?->slug,
        ];
    }

    protected function getBlogs(): BlogListCollection
    {
        return new BlogListCollection(
            Blog::query()
                ->when($this->tag?->exists, fn (Builder $builder) => $builder->whereHas(
                    'tags',
                    fn (Builder $builder) => $builder->where('slug', $this->tag?->slug)
                ))
                ->with(['media', 'tags'])
//                ->withCount(['comments'])
                ->latest()
                ->paginate(12)
        );
    }

    /** @return Collection<int, BlogTag> */
    protected function getTags(): Collection
    {
        return BlogTag::query()
            ->withCount(['blogs' => fn (Builder $builder) => $builder->where('live', true)])
            ->orderByDesc('blogs_count')
            ->limit(14)
            ->get(['tag', 'slug', 'blogs_count']);
    }
}
