<?php

declare(strict_types=1);

namespace App\Modules\Blog\Models;

use App\Modules\Shared\Support\DisplaysMedia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $title
 * @property Collection<BlogTag> $tags
 * @property string $meta_description
 * @property string $meta_keywords
 * @property int $id
 * @property bool $live
 * @property Carbon $created_at
 * @property string $description
 * @property Carbon $updated_at
 *
 * @method transform(array $array)
 */
class Blog extends Model implements HasMedia
{
    use DisplaysMedia;
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('social')->singleFile();

        $this->addMediaCollection('primary')->singleFile();

        $this->addMediaCollection('body');
    }

    /** @return BelongsToMany<BlogTag> */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_assigned_tags',
            'blog_id',
            'tag_id'
        )->withTimestamps();
    }
}
