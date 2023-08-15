<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Blogs\GetLatestBlogsForHomepageAction;
use App\Actions\Collections\GetLatestCollectionsForHomepageAction;
use App\Actions\Recipes\GetLatestRecipesForHomepageAction;
use App\Http\Response\Inertia;
use Inertia\Response;

class HomeController
{
    public function __invoke(
        Inertia $inertia,
        GetLatestBlogsForHomepageAction $getLatestBlogsForHomepageAction,
        GetLatestRecipesForHomepageAction $getLatestRecipesForHomepageAction,
        GetLatestCollectionsForHomepageAction $getLatestCollectionsForHomepageAction
    ): Response {
        return $inertia->render('Home', [
            'blogs' => $getLatestBlogsForHomepageAction->handle(),
            'recipes' => $getLatestRecipesForHomepageAction->handle(),
            'collections' => $getLatestCollectionsForHomepageAction->handle(),
        ]);
    }
}
