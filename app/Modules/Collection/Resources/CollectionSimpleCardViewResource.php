<?php

declare(strict_types=1);

namespace App\Modules\Collection\Resources;

use App\Modules\Collection\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Collection */
class CollectionSimpleCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => route('collection.show', ['collection' => $this]),
            'image' => $this->main_image,
        ];
    }
}
