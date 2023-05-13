<?php

declare(strict_types=1);

namespace App\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogSimpleCardViewResource;
use App\Modules\Collection\Models\Collection;
use App\Modules\Collection\Resources\CollectionSimpleCardViewResource;
use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Resources\RecipeSimpleCardViewResource;
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
                ->take(6)
                ->latest()
                ->with(['media'])
                ->get())
        );
    }

    public function recipes(): AnonymousResourceCollection
    {
        /** @var string $key */
        $key = config('coeliac.cache.recipes.home');

        return $this->cache->rememberForever(
            $key,
            fn () => RecipeSimpleCardViewResource::collection(Recipe::query()
                ->take(8)
                ->latest()
                ->with(['media'])
                ->get())
        );
    }

    public function collections(): AnonymousResourceCollection
    {
        /** @var string $key */
        $key = config('coeliac.cache.collections.home');

        return $this->cache->rememberForever(
            $key,
            fn () => CollectionSimpleCardViewResource::collection(Collection::query()
                ->where('display_on_homepage', true)
                ->latest('updated_at')
                ->with('media')
                ->get())
        );
    }
}
