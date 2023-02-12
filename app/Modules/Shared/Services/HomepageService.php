<?php

declare(strict_types=1);

namespace App\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogCardViewResource;
use App\Modules\Shared\DataObjects\NavigationItem;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class HomepageService
{
    public function __construct(protected CacheRepository $cache)
    {
        //
    }

    public function blogs(): AnonymousResourceCollection
    {
        /** @var string $key */
        $key = config('coeliac.cache.blogs.home');

        return $this->cache->rememberForever(
            $key,
            fn () => BlogCardViewResource::collection(Blog::query()
                ->take(2)
                ->latest()
                ->with(['media'])
                ->get())
        );
    }
}
