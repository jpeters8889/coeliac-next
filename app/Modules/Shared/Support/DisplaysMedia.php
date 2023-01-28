<?php

declare(strict_types=1);

namespace App\Modules\Shared\Support;

use App\Modules\Shared\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property string $main_image
 * @property string $social_image
 * @property string $square_image
 * @property string $first_image
 * @mixin HasMedia
 */
trait DisplaysMedia
{
    public function getFirstImageAttribute(): ?string
    {
        /** @var MediaCollection<int, Media> $collection */
        $collection = $this->getMedia();

        return isset($collection[0]) ? $collection[0]->getUrl() : null;
    }

    public function getMainImageAttribute(): ?string
    {
        /** @var MediaCollection<int, Media> $collection */
        $collection = $this->getMedia('primary');

        return isset($collection[0]) ? $collection[0]->getUrl() : null;
    }

    public function getSocialImageAttribute(): ?string
    {
        /** @var MediaCollection<int, Media> $collection */
        $collection = $this->getMedia('social');

        return isset($collection[0]) ? $collection[0]->getUrl() : null;
    }

    public function getSquareImageAttribute(): ?string
    {
        /** @var MediaCollection<int, Media> $collection */
        $collection = $this->getMedia('square');

        return isset($collection[0]) ? $collection[0]->getUrl() : null;
    }
}
