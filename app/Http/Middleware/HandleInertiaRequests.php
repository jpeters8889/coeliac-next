<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Modules\Shared\Services\NavigationService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    public function __construct(protected NavigationService $navigationService)
    {
        //
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'navigation' => fn () => [
                'blogs' => $this->navigationService->blogs(),
            ],
        ]);
    }
}
