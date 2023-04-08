<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Shared\Services\HomepageService;
use Inertia\Response;

class HomeController
{
    public function __invoke(Inertia $inertia, HomepageService $service): Response
    {
        return $inertia->render('Home', [
            'blogs' => $service->blogs(),
            'recipes' => $service->recipes(),
        ]);
    }
}
