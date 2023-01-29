<?php

declare(strict_types=1);

namespace App\Legacy;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @deprecated
 *
 * @property Collection<ImageAssociations> $images
 * @mixin Model
 */
trait Imageable
{
    public static function bootImageable(): void
    {
        self::with(['images', 'images.image']);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(ImageAssociations::class, 'imageable');
    }

    public function associateImage(Image $image, int $category = Image::IMAGE_CATEGORY_GENERAL): static
    {
        $this->images()->create([
            'image_id' => $image->getKey(),
            'imageable_id' => $this->getKey(),
            'imageable_type' => static::class,
            'image_category_id' => $category,
        ]);

        return $this;
    }
}
