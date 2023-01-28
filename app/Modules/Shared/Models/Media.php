<?php

namespace App\Modules\Shared\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

/**
 * @extends Model
 *
 * @property HasMedia $model
 * @property int $model_id
 */
class Media extends Model
{
    protected static function booted(): void
    {
        static::creating(function(self $media) {
            if($media->model->slug) {
                $media->setCustomProperty('slug', $media->model->slug);
            }
        });
    }
}
