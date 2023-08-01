<?php

declare(strict_types=1);

namespace App\Resources\Collections;

use App\Models\Collections\CollectionItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CollectionItem
 * @property CollectionItem $item
 */
class CollectedItemSimpleCardViewResource extends JsonResource
{
    /** @return array{type: string, title: string, link: string, image: string, square_image: string} */
    public function toArray(Request $request)
    {
        return [
            'type' => class_basename($this->item),
            'title' => $this->item->title,
            'link' => $this->item->link,
            'image' => $this->item->main_image,
            'square_image' => $this->item->square_image,
        ];
    }
}
