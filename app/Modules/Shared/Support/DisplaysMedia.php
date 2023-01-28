<?php

namespace App\Modules\Shared\Support;

use Spatie\MediaLibrary\HasMedia;

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
        return isset($this->getMedia()[0]) ? $this->getMedia()[0]->getUrl() : null;
    }

    public function getMainImageAttribute(): ?string
    {
        return isset($this->getMedia('primary')[0]) ? $this->getMedia('primary')[0]->getUrl() : null;
    }

    public function getSocialImageAttribute(): ?string
    {
        return isset($this->getMedia('social')[0]) ? $this->getMedia('social')[0]->getUrl() : null;
    }

    public function getSquareImageAttribute(): ?string
    {
        return isset($this->getMedia('square')[0]) ? $this->getMedia('square')[0]->getUrl() : null;
    }

    public function getSquareImageRawAttribute(): ?string
    {
        return $this->square_image;
    }
}
