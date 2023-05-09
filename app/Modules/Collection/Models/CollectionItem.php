<?php

declare(strict_types=1);

namespace App\Modules\Collection\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

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
