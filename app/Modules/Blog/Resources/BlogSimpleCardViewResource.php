<?php

declare(strict_types=1);

namespace App\Modules\Blog\Resources;

use App\Modules\Blog\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Blog */
class BlogSimpleCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, description: string} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->main_image,
            'description' => $this->meta_description,
        ];
    }
}
