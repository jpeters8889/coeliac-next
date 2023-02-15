<?php

declare(strict_types=1);

namespace App\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogSimpleCardViewResource;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
            fn () => BlogSimpleCardViewResource::collection(Blog::query()
                ->take(2)
                ->latest()
                ->with(['media'])
                ->get())
        );
    }
}
