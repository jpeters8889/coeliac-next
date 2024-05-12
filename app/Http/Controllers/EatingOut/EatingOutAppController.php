<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Http\Response\Inertia;
use Inertia\Response;

class EatingOutAppController
{
    public function __invoke(Inertia $inertia): Response
    {
        return $inertia
            ->title('Coeliac Sanctuary - On the Go')
            ->metaDescription('Coeliac Sanctuary on the go | Find Gluten Free places to eat out across the UK with our Coeliac Sanctuary - On the Go app')
            ->metaTags(['Coeliac sanctuary app', 'gluten free places to eat', 'coeliac sanctuary on the go', 'coeliac places to eat', 'android app', 'apple app', 'ios app'])
            ->metaImage(asset('images/share-images/wheretoeat-app.jpg'))
            ->render('EatingOut/CoeliacSanctuaryOnTheGo');
    }
}