<?php

declare(strict_types=1);

namespace App\Modules\Collection\Resources;

use App\Modules\Collection\Models\CollectionItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CollectionItem */
class CollectedItemResource extends JsonResource
{
    /** @return array */
    public function toArray(Request $request)
    {
        return [
            'type' => class_basename($this->item),
            'title' => $this->item->title,
            'image' => $this->item->main_image,
            'square_image' => $this->item->square_image,
            'date' => $this->item->lastUpdated,
            'description' => $this->item->meta_description,
            'link' => $this->item->link,
        ];
    }
}
