<?php

declare(strict_types=1);

namespace App\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Shared\DataObjects\NavigationItem;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;

class NavigationService
{
    public function __construct(protected CacheRepository $cache)
    {
        //
    }

    /** @return Collection<int, NavigationItem> */
    public function blogs(): Collection
    {
        /** @var string $key */
        $key = config('coeliac.cache.blogs.navigation');

        return $this->cache->rememberForever(
            $key,
            fn () => Blog::query()
                ->take(8)
                ->with(['media'])
                ->get()
                ->map(fn (Blog $blog) => new NavigationItem(
                    $blog->title,
                    $blog->slug,
                    $blog->meta_description,
                    $blog->main_image,
                ))
        );
    }
}
