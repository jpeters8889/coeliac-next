<?php

declare(strict_types=1);

namespace App\Modules\Blog\Models;

use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Modules\Shared\Comments\Commentable;
use App\Modules\Shared\Comments\HasComments;
use App\Modules\Shared\Scopes\LiveScope;
use App\Modules\Shared\Support\DisplaysDates;
use App\Modules\Shared\Support\DisplaysMedia;
use App\Modules\Shared\Support\LinkableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $title
 * @property Collection<BlogTag> $tags
 * @property string $meta_description
 * @property string $meta_tags
 * @property int $id
 * @property string $body
 * @property bool $live
 * @property Carbon $created_at
 * @property string $description
 * @property Carbon $updated_at
 * @property string $published
 * @property string $lastUpdated
 * @property null | int $comments_count
 */
class Blog extends Model implements HasComments, HasMedia
{
    use Commentable;
    use DisplaysDates;
    use DisplaysMedia;
    use LinkableModel;
    use HasLegacyImage;
    use Imageable;

    use InteractsWithMedia;

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope());
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    protected function linkRoot(): string
    {
        return 'blog';
    }
}
