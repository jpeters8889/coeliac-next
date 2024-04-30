<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /** @return array | object */
    public function resolveValidationErrors(Request $request)
    {
        $errors = (array) parent::resolveValidationErrors($request);

        return (array) collect($errors)->undot()->toArray();
    }
}
