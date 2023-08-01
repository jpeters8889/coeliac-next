<?php

declare(strict_types=1);

namespace App\Actions\Blogs;

use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use App\Resources\Blogs\BlogListCollection;
use Illuminate\Database\Eloquent\Builder;

class GetBlogsForBlogIndexAction
{
    public function __invoke(?BlogTag $tag = null, int $perPage = 12): BlogListCollection
    {
        return new BlogListCollection(
            Blog::query()
                ->when($tag?->exists, fn (Builder $builder) => $builder->whereHas(
                    'tags',
                    fn (Builder $builder) => $builder->where('slug', $tag?->slug)
                ))
                ->with(['media', 'tags'])
                ->withCount(['comments'])
                ->latest()
                ->paginate($perPage)
        );

    }
}
