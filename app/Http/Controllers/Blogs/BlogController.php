<?php

declare(strict_types=1);

namespace App\Http\Controllers\Blogs;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Actions\Blogs\GetBlogTagsAction;
use App\Actions\Comments\GetCommentsForItemAction;
use App\Http\Response\Inertia;
use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use App\Resources\Blogs\BlogShowResource;
use Inertia\Response;

class BlogController
{
    public function index(Inertia $inertia, GetBlogsForBlogIndexAction $getBlogsForBlogIndexAction, GetBlogTagsAction $getBlogTagsAction, BlogTag $tag): Response
    {
        return $inertia
            ->title('Gluten Free Blogs' . ($tag->exists ? " tagged with {$tag->tag}" : ''))
            ->metaDescription('Coeliac Sanctuary gluten free blog list | All of our Coeliac blog posts in one list')
            ->metaTags(['coeliac sanctuary blog', 'blog', 'coeliac blog', 'gluten free blog', ...($tag->exists ? ["{$tag->tag} blogs"] : [])])
            ->render('Blog/Index', [
                'blogs' => fn () => $getBlogsForBlogIndexAction($tag),
                'tags' => fn () => $getBlogTagsAction(),
                'activeTag' => $tag->exists ? $tag : null,
            ]);
    }

    public function show(Blog $blog, Inertia $inertia, GetCommentsForItemAction $commentsForItemAction): Response
    {
        return $inertia
            ->title($blog->title)
            ->metaDescription($blog->meta_description)
            ->metaTags(explode(',', $blog->meta_tags))
            ->metaImage($blog->social_image)
            ->alternateMetas([
                'article:publisher' => 'https://www.facebook.com/coeliacsanctuary',
                'article:section' => 'Food',
                'article:published_time' => $blog->created_at,
                'article:modified_time' => $blog->updated_at,
                'article:author' => 'Coeliac Sanctuary',
                'article.tags' => $blog->meta_tags,
            ])
            ->schema($blog->schema()->toScript())
            ->render('Blog/Show', [
                'blog' => new BlogShowResource($blog),
                'comments' =>  fn () => $commentsForItemAction($blog),
            ]);
    }
}
