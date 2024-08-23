<?php

declare(strict_types=1);

namespace App\Http\Controllers\WorkWithUs;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction): Response
    {
        return $inertia
            ->title('Work With Coeliac Sanctuary')
            ->metaDescription('Want Coeliac Sanctuary to help promote your brand? Find out how we can help here!')
            ->metaImage($getOpenGraphImageForRouteAction->handle())
            ->render('WorkWithUs');
    }
}
