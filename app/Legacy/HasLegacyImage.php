<?php

declare(strict_types=1);

namespace App\Legacy;

/**
 * @deprecated
 *
 * @property string $main_image
 * @property string $social_image
 * @property string $square_image
 * @property string $first_image
 */
trait HasLegacyImage
{
    public function getFirstLegacyImageAttribute(): ?string
    {
        return $this->images->first()->image->image_url ?? null;
    }

    public function getMainLegacyImageAttribute(): ?string
    {
        return $this->images
            ->whereIn('image_category_id', [Image::IMAGE_CATEGORY_HEADER, Image::IMAGE_CATEGORY_SQUARE])
            ->sortBy('image_category_id')
            ->first()->image->image_url ?? null;
    }

    public function getMainLegacyImageRawAttribute(): ?string
    {
        return $this->images
            ->whereIn('image_category_id', [Image::IMAGE_CATEGORY_HEADER, Image::IMAGE_CATEGORY_SQUARE])
            ->sortBy('image_category_id')
            ->first()->image->raw_url ?? null;
    }

    public function getSocialLegacyImageAttribute(): ?string
    {
        return $this->images->firstWhere('image_category_id', Image::IMAGE_CATEGORY_SOCIAL)->image->image_url ?? null;
    }

    public function getSquareLegacyImageAttribute(): ?string
    {
        return $this->images->firstWhere('image_category_id', Image::IMAGE_CATEGORY_SQUARE)->image->image_url ?? null;
    }

    public function getSquareLegacyImageRawAttribute(): ?string
    {
        return $this->images->firstWhere('image_category_id', Image::IMAGE_CATEGORY_SQUARE)->image->raw_url ?? null;
    }
}
