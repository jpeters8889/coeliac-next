<?php

declare(strict_types=1);

namespace App\Modules\Collection\Resources;

use App\Modules\Collection\Models\CollectionItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CollectionItem */
class FeaturedInCollectionSimpleCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->collection->title,
            'link' => route('collection.show', ['collection' => $this->collection]),
        ];
    }
}
