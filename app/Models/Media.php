<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

/**
 * @property HasMedia $model
 * @property int $model_id
 * @property string $model_type
 */
class Media extends Model
{
    protected static function booted(): void
    {
        static::creating(function (self $media): void {
            if (isset($media->model->slug)) {
                $media->setCustomProperty('slug', $media->model->slug);
            }
        });
    }
}
