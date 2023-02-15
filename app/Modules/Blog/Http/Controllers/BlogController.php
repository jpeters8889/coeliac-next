<?php

declare(strict_types=1);

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogListCollection;
use Inertia\Response;

class BlogController
{
    public function index(Inertia $inertia): Response
    {
        return $inertia->render('Blog/Index', [
            'blogs' => new BlogListCollection(Blog::query()
                ->with(['tags'])
//                ->withCount(['comments'])
                ->latest()
                ->paginate(12)),
        ]);
    }
}
