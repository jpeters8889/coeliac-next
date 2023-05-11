<?php

declare(strict_types=1);

namespace App\Modules\Collection\Resources;

use App\Modules\Collection\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Collection */
class CollectionShowResource extends JsonResource
{
    /** @return array */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->main_image,
            'published' => $this->published,
            'updated' => $this->lastUpdated,
            'description' => $this->description,
            'body' => $this->body,
            'items' => new CollectedItemCollection($this->items),
        ];
    }
}
