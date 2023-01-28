<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Controllers;

use App\Http\Response\Inertia;
use Inertia\Response;

class HomeController
{
    public function __invoke(Inertia $inertia): Response
    {
        return $inertia->render('Home');
    }
}
