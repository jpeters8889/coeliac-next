<?php

declare(strict_types=1);

namespace App\Modules\Blog\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogListCollection extends ResourceCollection
{
    public $collects = BlogDetailCardViewResource::class;
}
