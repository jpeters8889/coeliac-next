<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Concerns\DisplaysMedia;
use App\Concerns\LinkableModel;
use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ShopCategory extends Model implements HasMedia
{
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;
    use InteractsWithMedia;
    use LinkableModel;

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope(
            fn (Builder $builder) => $builder
                ->whereHas('products', fn (Builder $builder) => $builder->whereHas('variants'))
        ));
    }

    /** @return BelongsToMany<ShopProduct> */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ShopProduct::class, 'shop_product_categories', 'category_id', 'product_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('social')->singleFile();

        $this->addMediaCollection('primary')->singleFile();
    }

    public function getRouteKey()
    {
        return 'slug';
    }

    protected function linkRoot(): string
    {
        return 'shop';
    }
}