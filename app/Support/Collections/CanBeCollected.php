<?php

declare(strict_types=1);

namespace App\Support\Collections;

use App\Models\Collections\CollectionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait CanBeCollected
{
    /** @return MorphMany<CollectionItem> */
    public function associatedCollections(): MorphMany
    {
        return $this->morphMany(CollectionItem::class, 'item');
    }
}
