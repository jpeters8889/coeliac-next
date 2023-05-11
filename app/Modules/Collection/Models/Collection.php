<?php

declare(strict_types=1);

namespace App\Modules\Collection\Models;

use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Modules\Collection\Support\Collectable;
use App\Modules\Shared\Scopes\LiveScope;
use App\Modules\Shared\Support\CanBePublished;
use App\Modules\Shared\Support\DisplaysDates;
use App\Modules\Shared\Support\DisplaysMedia;
use App\Modules\Shared\Support\LinkableModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $title
 * @property string $meta_description
 * @property string $meta_tags
 * @property int $id
 * @property string $published
 * @property string $lastUpdated
 * @property string $description
 * @property string $long_description
 * @property string | null $body
 */
class Collection extends Model implements HasMedia
{
    use CanBePublished;
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

        $this->addMediaCollection('primary')->singleFile()->withResponsiveImages();
    }

    /** @return HasMany<CollectionItem> */
    public function items(): HasMany
    {
        return $this->hasMany(CollectionItem::class)->orderBy('position');
    }

    protected function linkRoot(): string
    {
        return 'collection';
    }

    public function addItem(Collectable $item, string $description, ?int $position = null): static
    {
        $this->items()->create([
            'item_id' => $item->getKey(),
            'item_type' => get_class($item),
            'description' => $description,
            'position' => $position ?? $this->items()->max('position') + 1,
        ]);

        return $this;
    }

    /** @return Attribute<string, never> */
    public function description(): Attribute
    {
        return Attribute::get(fn() => $this->long_description);
    }

    /** @return Attribute<string, never> */
    public function metaTags(): Attribute
    {
        return Attribute::get(fn() => $this->meta_keywords);
    }
}
