<?php

declare(strict_types=1);

namespace App\Support\Collections;

use App\Models\Collections\CollectionItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property string $title
 * @property string $meta_description
 * @property string $main_image
 * @property string $lastUpdated
 */
interface Collectable
{
    /** @phpstan-return mixed */
    public function getKey();

    /** @return MorphMany<CollectionItem> */
    public function associatedCollections(): MorphMany;
}
