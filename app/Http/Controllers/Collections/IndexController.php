<?php

declare(strict_types=1);

namespace App\Http\Controllers\Collections;

use App\Actions\Collections\GetCollectionsForIndexAction;
use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, GetCollectionsForIndexAction $getCollectionsForIndexAction, GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction): Response
    {
        return $inertia
            ->title('Collections')
            ->metaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->metaImage($getOpenGraphImageForRouteAction->handle('collection'))
            ->render('Collection/Index', [
                'collections' => $getCollectionsForIndexAction->handle(),
            ]);
    }
}
