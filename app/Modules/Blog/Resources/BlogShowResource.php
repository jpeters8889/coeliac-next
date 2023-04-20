<?php

declare(strict_types=1);

namespace App\Modules\Blog\Resources;

use App\Modules\Blog\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin Blog
 */
class BlogShowResource extends JsonResource
{
    /** @return array{id: number, title: string, image: string, created_at: Carbon, updated_at: Carbon, description: string, body: string, tags: BlogTagCollection} */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->main_image,
            'published' => $this->published,
            'updated' => $this->lastUpdated,
            'description' => $this->description,
            'body' => Str::markdown($this->body),
            'tags' => new BlogTagCollection($this->tags),
        ];
    }
}
