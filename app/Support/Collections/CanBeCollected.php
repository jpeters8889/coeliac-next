<?php

declare(strict_types=1);

namespace App\Support\Collections;

use App\Models\Collections\CollectionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @template T of Model
 *
 * @mixin Model
 */
trait CanBeCollected
{
    /** @return MorphMany<CollectionItem, T> */
    public function associatedCollections(): MorphMany
    {
        return $this->morphMany(CollectionItem::class, 'item');
    }
}
