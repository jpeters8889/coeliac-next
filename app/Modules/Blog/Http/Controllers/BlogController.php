<?php

declare(strict_types=1);

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Blog\Support\BlogIndexDataRetriever;
use Inertia\Response;

class BlogController
{
    public function index(Inertia $inertia, BlogIndexDataRetriever $blogDataRetriever, BlogTag $tag): Response
    {
        return $inertia
            ->title('Gluten Free Blogs' . ($tag->exists ? " tagged with {$tag->tag}" : ''))
            ->metaDescription('Coeliac Sanctuary gluten free blog list | All of our Coeliac blog posts in one list')
            ->metaTags(['coeliac sanctuary blog', 'blog', 'coeliac blog', 'gluten free blog', ...($tag->exists ? ["{$tag->tag} blogs"] : [])])
            ->render('Blog/Index', $blogDataRetriever->setTag($tag)->getData());
    }
}
