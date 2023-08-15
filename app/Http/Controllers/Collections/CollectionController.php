<?php

declare(strict_types=1);

namespace App\Http\Controllers\Collections;

use App\Actions\Collections\GetCollectionsForIndexAction;
use App\Http\Response\Inertia;
use App\Models\Collections\Collection;
use App\Resources\Collections\CollectionShowResource;
use Inertia\Response;

class CollectionController
{
    public function index(Inertia $inertia, GetCollectionsForIndexAction $getCollectionsForIndexAction): Response
    {
        return $inertia
            ->title('Collections')
            ->metaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->render('Collection/Index', [
                'collections' => $getCollectionsForIndexAction->handle(),
            ]);
    }

    public function show(Inertia $inertia, Collection $collection): Response
    {
        $collection->load(['items', 'items.item', 'items.item.media']);

        return $inertia
            ->title($collection->title)
            ->metaDescription($collection->meta_description)
            ->metaTags(explode(',', $collection->meta_tags))
            ->metaImage($collection->social_image)
            ->render('Collection/Show', [
                'collection' => new CollectionShowResource($collection),
            ]);

    }
}
