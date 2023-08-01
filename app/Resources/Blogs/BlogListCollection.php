<?php

declare(strict_types=1);

namespace App\Resources\Blogs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogListCollection extends ResourceCollection
{
    public $collects = BlogDetailCardViewResource::class;
}
