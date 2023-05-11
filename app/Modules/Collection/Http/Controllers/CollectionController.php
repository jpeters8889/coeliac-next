<?php

declare(strict_types=1);

namespace App\Modules\Collection\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Collection\Models\Collection;
use App\Modules\Collection\Resources\CollectionShowResource;
use App\Modules\Collection\Support\CollectionIndexDataRetriever;
use Inertia\Response;

class CollectionController
{
    public function index(Inertia $inertia, CollectionIndexDataRetriever $collectionDataRetriever): Response
    {
        return $inertia
            ->title('Collections')
            ->metaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->render('Collection/Index', $collectionDataRetriever->getData());
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
