<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Blogs;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Resources\Blogs\BlogApiCollection;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request, GetBlogsForBlogIndexAction $getBlogsForBlogIndexAction): BlogApiCollection
    {
        return $getBlogsForBlogIndexAction->handle(resource: BlogApiCollection::class, search: $request->get('search'));
    }
}
