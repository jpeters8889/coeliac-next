<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

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
