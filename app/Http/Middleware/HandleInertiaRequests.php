<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    public function resolveValidationErrors(Request $request)
    {
        $errors = parent::resolveValidationErrors($request);

        return (object) collect($errors)->undot()->toArray();
    }
}
