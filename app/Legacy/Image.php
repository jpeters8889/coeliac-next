<?php

declare(strict_types=1);

namespace App\Legacy;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Filesystem\FilesystemManager;

/**
 * @deprecated
 *
 * @property string $directory
 * @property string $file_name
 * @property string $image_url
 * @property string $raw_url
 */
class Image extends Model
{
    public const IMAGE_CATEGORY_GENERAL = 1;
    public const IMAGE_CATEGORY_HEADER = 2;
    public const IMAGE_CATEGORY_SOCIAL = 3;
    public const IMAGE_CATEGORY_SQUARE = 4;
    public const IMAGE_CATEGORY_HERO = 5;
    public const IMAGE_CATEGORY_POPUP = 6;
    public const IMAGE_CATEGORY_SHOP_CATEGORY = 7;
    public const IMAGE_CATEGORY_SHOP_PRODUCT = 8;

    protected $appends = ['image_url'];

    public static function booted(): void
    {
        static::deleted(static function (Image $image): void {
            Container::getInstance()->make(FilesystemManager::class)
                ->disk('images')
                ->delete($image->directory . '/' . $image->file_name);
        });
    }

    public function associations(): HasMany
    {
        return $this->hasMany(ImageAssociations::class);
    }

    public function getRawUrlAttribute(): string
    {
        return Container::getInstance()->make(FilesystemManager::class)->disk('images')->url($this->directory . '/' . $this->file_name);
    }

    public function getImageUrlAttribute(): string
    {
        if (config('app.env') === 'testing') {
            // @todo this sucks
            return Container::getInstance()->make(FilesystemManager::class)->disk('images')->url($this->directory . '/' . $this->file_name);
        }

        return implode('/', [
            config('coeliac.images_url'),
            $this->directory,
            $this->file_name,
        ]);
    }
}
