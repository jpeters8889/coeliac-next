<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Str;

/**
 * @property Eatery $eatery
 * @property string $id
 * @property mixed $rating
 */
class EateryReviewImage extends Model
{
    protected $table = 'wheretoeat_review_images';

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function booted(): void
    {
        self::creating(function (self $model) {
            $model->id ??= Str::uuid()->toString();

            return $model;
        });
    }

    /** @return BelongsTo<Eatery, EateryReviewImage> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id', 'id');
    }

    /** @return BelongsTo<EateryReview, EateryReviewImage> */
    public function review(): BelongsTo
    {
        return $this->belongsTo(EateryReview::class, 'wheretoeat_review_id', 'id');
    }

    /** @return Attribute<string, never> */
    public function thumb(): Attribute
    {
        return Attribute::get(fn () => $this->imageUrl($this->attributes['thumb']));
    }

    /** @return Attribute<string, never> */
    public function path(): Attribute
    {
        return Attribute::get(fn () => $this->imageUrl($this->attributes['path']));
    }

    protected function imageUrl(string $file): string
    {
        return app(FilesystemManager::class)->disk('review-images')->url($file);
    }
}
