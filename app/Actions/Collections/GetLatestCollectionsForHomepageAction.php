<?php

declare(strict_types=1);

namespace App\Actions\Collections;

use App\Models\Collections\Collection;
use App\Resources\Collections\CollectionSimpleCardViewResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class GetLatestCollectionsForHomepageAction
{
    public function __invoke(): AnonymousResourceCollection
    {
        /** @var string $key */
        $key = config('coeliac.cache.collections.home');

        return Cache::rememberForever(
            $key,
            fn () => CollectionSimpleCardViewResource::collection(Collection::query()
                ->where('display_on_homepage', true)
                ->latest('updated_at')
                ->with(['media'])
                ->get())
        );
    }
}