<?php

declare(strict_types=1);

namespace App\Http\Controllers\TermsOfUse;

use App\Http\Response\Inertia;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia): Response
    {
        return $inertia
            ->title('Terms of Use')
            ->doNotTrack()
            ->render('TermsOfUse');
    }
}
