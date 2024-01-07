<?php

declare(strict_types=1);

namespace App\Http\Controllers\Blogs;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Actions\Blogs\GetBlogTagsAction;
use App\Http\Response\Inertia;
use App\Models\Blogs\BlogTag;
use Inertia\Response;

class BlogIndexController
{
    public function __invoke(Inertia $inertia, GetBlogsForBlogIndexAction $getBlogsForBlogIndexAction, GetBlogTagsAction $getBlogTagsAction, BlogTag $tag): Response
    {
        return $inertia
            ->title('Gluten Free Blogs' . ($tag->exists ? " tagged with {$tag->tag}" : ''))
            ->metaDescription('Coeliac Sanctuary gluten free blog list | All of our Coeliac blog posts in one list')
            ->metaTags(['coeliac sanctuary blog', 'blog', 'coeliac blog', 'gluten free blog', ...($tag->exists ? ["{$tag->tag} blogs"] : [])])
            ->render('Blog/Index', [
                'blogs' => fn () => $getBlogsForBlogIndexAction->handle($tag),
                'tags' => fn () => $getBlogTagsAction->handle(),
                'activeTag' => $tag->exists ? $tag : null,
            ]);
    }
}