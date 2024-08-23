<?php

declare(strict_types=1);

namespace App\Http\Controllers\About;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction): Response
    {
        return $inertia
            ->title('About Us')
            ->metaDescription('Find out more about Coeliac Sanctuary, our history, and the people who run it!')
            ->metaImage($getOpenGraphImageForRouteAction->handle())
            ->render('About');
    }
}
