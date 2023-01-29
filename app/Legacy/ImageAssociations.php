<?php

declare(strict_types=1);

namespace App\Legacy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @deprecated
 *
 * @property Image         $image
 * @property ImageCategory $category
 */
class ImageAssociations extends Model
{
    protected $with = ['image'];

    protected static function booted()
    {
        self::deleting(function (self $imageAssociation) {
            $imageAssociation->image()->delete();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ImageCategory::class, 'image_category_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo('imageable');
    }

    public function scopeCategory(Builder $builder, int $category): Builder
    {
        return $builder->where('image_category_id', $category);
    }
}
