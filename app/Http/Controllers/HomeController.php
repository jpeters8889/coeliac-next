<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Blogs\GetLatestBlogsForHomepageAction;
use App\Actions\Collections\GetLatestCollectionsForHomepageAction;
use App\Actions\EatingOut\GetLatestEateriesForHomepageAction;
use App\Actions\EatingOut\GetLatestReviewsForHomepageAction;
use App\Actions\Recipes\GetLatestRecipesForHomepageAction;
use App\Http\Response\Inertia;
use Inertia\Response;
use Spatie\SchemaOrg\Schema;

class HomeController
{
    public function __invoke(
        Inertia $inertia,
        GetLatestBlogsForHomepageAction $getLatestBlogsForHomepageAction,
        GetLatestRecipesForHomepageAction $getLatestRecipesForHomepageAction,
        GetLatestCollectionsForHomepageAction $getLatestCollectionsForHomepageAction,
        GetLatestReviewsForHomepageAction $getLatestReviewsForHomepageAction,
        GetLatestEateriesForHomepageAction $getLatestEateriesForHomepageAction,
    ): Response {
        return $inertia
            ->schema(
                Schema::person()
                    ->name('Alison Peters')
                    ->email('contact@coeliacsanctuary.co.uk')
                    ->sameAs([
                        'https://www.facebook.com/coeliacsanctuary',
                        'https://twitter.com/coeliacsanc',
                        'https://www.instagram.com/coeliacsanctuary',
                    ])
                    ->toScript()
            )
            ->render('Home', [
                'blogs' => $getLatestBlogsForHomepageAction->handle(),
                'recipes' => $getLatestRecipesForHomepageAction->handle(),
                'collections' => $getLatestCollectionsForHomepageAction->handle(),
                'latestReviews' => $getLatestReviewsForHomepageAction->handle(),
                'latestEateries' => $getLatestEateriesForHomepageAction->handle(),
            ]);
    }
}
