<?php

declare(strict_types=1);

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Blog\Resources\BlogShowResource;
use App\Modules\Blog\Support\BlogIndexDataRetriever;
use App\Modules\Shared\Comments\Resources\CommentCollection;
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

    public function show(Blog $blog, Inertia $inertia): Response
    {
        return $inertia
            ->title($blog->title)
            ->metaDescription($blog->meta_description)
            ->metaTags(explode(',', $blog->meta_tags))
            ->metaImage($blog->social_image)
            ->schema($blog->schema()->toScript())
            ->render('Blog/Show', [
                'blog' => new BlogShowResource($blog),
                'comments' =>  fn () => new CommentCollection(
                    $blog->comments()
                        ->with('reply')
                        ->simplePaginate(5, pageName: 'commentPage')
                ),
            ]);
    }
}
