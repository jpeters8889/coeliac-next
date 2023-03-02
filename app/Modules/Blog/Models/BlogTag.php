<?php

declare(strict_types=1);

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $tag;
 * @property string $slug;
 * @property int $id
 * @property int | null $blogs_count
 */
class BlogTag extends Model
{
    use HasSlug;

    /** @return BelongsToMany<Blog> */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_assigned_tags', 'tag_id', 'blog_id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('tag')
            ->saveSlugsTo('slug');
    }

    public function resolveRouteBinding($value, $field = null): self
    {
        return $this->newQuery()->where('slug', $value)->firstOrFail();
    }
}
