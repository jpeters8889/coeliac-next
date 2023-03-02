<?php

declare(strict_types=1);

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Blog\Support\BlogIndexDataRetriever;
use Inertia\Response;

class BlogController
{
    public function index(Inertia $inertia, BlogIndexDataRetriever $blogDataRetriever, ?BlogTag $tag): Response
    {
        return $inertia->render('Blog/Index', $blogDataRetriever->setTag($tag)->getData());
    }
}
