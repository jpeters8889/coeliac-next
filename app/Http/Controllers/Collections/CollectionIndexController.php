<?php

declare(strict_types=1);

namespace App\Http\Controllers\Collections;

use App\Actions\Collections\GetCollectionsForIndexAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class CollectionIndexController
{
    public function __invoke(Inertia $inertia, GetCollectionsForIndexAction $getCollectionsForIndexAction): Response
    {
        return $inertia
            ->title('Collections')
            ->metaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->render('Collection/Index', [
                'collections' => $getCollectionsForIndexAction->handle(),
            ]);
    }
}
