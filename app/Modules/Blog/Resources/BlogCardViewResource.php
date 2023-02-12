<?php

declare(strict_types=1);

namespace App\Modules\Blog\Resources;

use App\Modules\Blog\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Blog */
class BlogCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, date: Carbon, description: string} */
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
