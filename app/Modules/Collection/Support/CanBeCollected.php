<?php

namespace App\Modules\Collection\Support;

use App\Modules\Collection\Models\CollectionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @mixin Model */
trait CanBeCollected
{
    /** @return MorphMany<CollectionItem> */
    public function associatedCollections(): MorphMany
    {
        return $this->morphMany(CollectionItem::class, 'item');
    }
}
