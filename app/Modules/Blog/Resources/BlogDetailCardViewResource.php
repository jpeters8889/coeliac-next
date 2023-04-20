<?php

declare(strict_types=1);

namespace App\Modules\Blog\Resources;

use App\Modules\Blog\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Blog */
class BlogDetailCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, date: Carbon, description: string, comments_count: number, tags: BlogTagCollection} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => route('blog.show', ['blog' => $this]),
            'image' => $this->main_image,
            'date' => $this->created_at,
            'description' => $this->meta_description,
            'comments_count' => $this->comments_count,
            'tags' => new BlogTagCollection($this->tags),
        ];
    }
}
