<?php

declare(strict_types=1);

namespace App\Resources\Blogs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogApiCollection extends ResourceCollection
{
    public $collects = BlogApiResource::class;
}
