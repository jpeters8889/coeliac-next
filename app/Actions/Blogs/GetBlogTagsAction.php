<?php

declare(strict_types=1);

namespace App\Actions\Blogs;

use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetBlogTagsAction
{
    /** @return Collection<int, BlogTag> */
    public function handle(int $limit = 14): Collection
    {
        return BlogTag::query()
            ->withCount(['blogs' => function (Builder $builder) {
                /** @var Builder<Blog> $builder */
                return $builder->where('live', true);
            }])
            ->orderByDesc('blogs_count')
            ->limit($limit)
            ->get(['tag', 'slug', 'blogs_count']);
    }
}
