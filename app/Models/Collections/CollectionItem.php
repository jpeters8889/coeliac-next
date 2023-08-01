<?php

declare(strict_types=1);

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property string $title
 * @property string $meta_description
 * @property string $main_image
 * @property string $square_image
 * @property string $lastUpdated
 * @property string $link
 * @property Collection $collection
 */
class CollectionItem extends Model implements Sortable
{
    use SortableTrait;

    public array $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];

    /** @return BelongsTo<Collection, CollectionItem> */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    /** @return MorphTo<Model, CollectionItem> */
    public function item(): MorphTo
    {
        return $this->morphTo('item');
    }
}
