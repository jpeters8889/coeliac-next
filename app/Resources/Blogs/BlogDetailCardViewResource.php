<?php

declare(strict_types=1);

namespace App\Resources\Blogs;

use App\Models\Blogs\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Blog */
class BlogDetailCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, date: string, description: string, comments_count: int|null, tags: BlogTagCollection} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => route('blog.show', ['blog' => $this]),
            'image' => $this->main_image,
            'date' => $this->published,
            'description' => $this->meta_description,
            'comments_count' => $this->comments_count,
            'tags' => new BlogTagCollection($this->tags),
        ];
    }
}
