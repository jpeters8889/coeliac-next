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
    /** @return array{title: string, link: string, image: string, date: Carbon, description: string, tags: BlogTagCollection} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->main_image,
            'date' => $this->created_at,
            'description' => $this->meta_description,
            //            'comments' => $this->comments_count,
            'tags' => new BlogTagCollection($this->tags),
        ];
    }
}
