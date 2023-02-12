<?php

namespace App\Modules\Blog\Resources;

use App\Modules\Blog\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Blog */
class BlogCardViewResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->main_image,
            'date' => $this->created_at,
            'description' => $this->meta_description,
        ];
    }
}
