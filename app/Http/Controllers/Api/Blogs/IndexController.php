<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Blogs;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Resources\Blogs\BlogApiCollection;

class IndexController
{
    public function __invoke(GetBlogsForBlogIndexAction $getBlogsForBlogIndexAction): BlogApiCollection
    {
        return $getBlogsForBlogIndexAction->handle(resource: BlogApiCollection::class);
    }
}
