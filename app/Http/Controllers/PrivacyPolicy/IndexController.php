<?php

declare(strict_types=1);

namespace App\Http\Controllers\PrivacyPolicy;

use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia): Response
    {
        return $inertia
            ->title('Privacy Policy')
            ->doNotTrack()
            ->render('PrivacyPolicy');
    }
}
