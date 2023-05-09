<?php

namespace App\Modules\Collection\Http\Controllers;

use App\Http\Response\Inertia;
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
}
