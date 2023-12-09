<?php

declare(strict_types=1);

namespace App\Resources\Collections;

use App\Models\Collections\Collection;
use App\Models\Collections\CollectionItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CollectionItem */
class FeaturedInCollectionSimpleCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string} */
    public function toArray(Request $request)
    {
        /** @var Collection $collection */
        $collection = $this->collection;

        return [
            'title' => $collection->title,
            'link' => route('collection.show', ['collection' => $collection]),
        ];
    }
}
