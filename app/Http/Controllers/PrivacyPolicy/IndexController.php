<?php

declare(strict_types=1);

namespace App\Http\Controllers\PrivacyPolicy;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction): Response
    {
        return $inertia
            ->title('Privacy Policy')
            ->doNotTrack()
            ->metaImage($getOpenGraphImageForRouteAction->handle())
            ->render('PrivacyPolicy');
    }
}
