<?php

declare(strict_types=1);

namespace App\Support\Collections;

use App\Models\Collections\CollectionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @template T of Model
 *
 * @property string $title
 * @property string $meta_description
 * @property string $main_image
 * @property string $lastUpdated
 */
interface Collectable
{
    /** @phpstan-return mixed */
    public function getKey();

    /** @return MorphMany<CollectionItem, T> */
    public function associatedCollections(): MorphMany;
}
