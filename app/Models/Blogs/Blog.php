<?php

declare(strict_types=1);

namespace App\Models\Blogs;

use App\Concerns\CanBePublished;
use App\Concerns\Comments\Commentable;
use App\Concerns\DisplaysDates;
use App\Concerns\DisplaysMedia;
use App\Concerns\LinkableModel;
use App\Contracts\Comments\HasComments;
use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Scopes\LiveScope;
use App\Support\Collections\CanBeCollected;
use App\Support\Collections\Collectable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\SchemaOrg\Blog as BlogSchema;
use Spatie\SchemaOrg\Schema;

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
class Blog extends Model implements Collectable, HasComments, HasMedia
{
    use CanBeCollected;
    use CanBePublished;
    use Commentable;
    use DisplaysDates;
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;
    use InteractsWithMedia;

    use LinkableModel;

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

    public function schema(): BlogSchema
    {
        /** @var string $url */
        $url = config('app.url');

        return Schema::blog()
            ->author(Schema::person()->name('Alison Peters'))
            ->dateModified($this->updated_at)
            ->datePublished($this->created_at)
            ->description($this->meta_description)
            ->headline($this->title)
            ->image($this->main_image)
            ->mainEntityOfPage(Schema::webPage()->identifier($url))
            ->publisher(
                Schema::organization()
                    ->name('Coeliac Sanctuary')
                    ->logo(Schema::imageObject()->url($url . "/images/logo.svg"))
            );
    }
}
