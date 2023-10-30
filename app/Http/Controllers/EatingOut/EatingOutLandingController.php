<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Http\Response\Inertia;
use Inertia\Response;

class EatingOutLandingController
{
    public function __invoke(Inertia $inertia): Response
    {
        return $inertia
            ->title('Gluten Free Eating Out')
            ->metaDescription('Coeliac Sanctuary places to eat overview | Find gluten free places to eat in the UK, attractions and hotels catering to Coeliac and reviews of places')
            ->metaTags([
                'Gluten free eating out', 'coeliac eating out', 'reviews', 'places to eat', 'uk places to eat', 'gluten free places to eat uk',
                'attractions uk gluten free', 'gluten free reviews', 'coeliac reviews', 'gluten free hotels', 'gluten free restaurants uk',
                'gluten free cafes uk',
            ])
            ->render('EatingOut/Landing');
    }
}
