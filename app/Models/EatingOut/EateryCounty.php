<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use App\Concerns\DisplaysMedia;
use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $county
 * @property EateryCountry $country
 * @property string $slug
 * @property int $reviews_count
 * @property Collection $activeTowns
 * @property int $id
 * @property string | null $image,
 */
class EateryCounty extends Model implements HasMedia
{
    use DisplaysMedia;
    use InteractsWithMedia;

    protected $table = 'wheretoeat_counties';

    protected static function booted(): void
    {
        static::addGlobalScope('hasPlaces', fn (Builder $builder) => $builder->whereHas('activeTowns'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary')->singleFile();
    }


    /** @return HasMany<EateryTown> */
    public function activeTowns(): HasMany
    {
        return $this->hasMany(EateryTown::class, 'county_id')->whereHas('liveEateries')->orderBy('town');
    }

    /** @return HasMany<Eatery> */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'county_id');
    }

    /** @return HasManyThrough<EateryReview> */
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(EateryReview::class, Eatery::class, 'county_id', 'wheretoeat_id');
    }

    /** @return HasMany<EateryTown> */
    public function towns(): HasMany
    {
        return $this->hasMany(EateryTown::class, 'county_id');
    }

    /** @return BelongsTo<EateryCountry, EateryCounty> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(EateryCountry::class, 'country_id');
    }

    public function keywords(): array
    {
        return [
            "coeliac {$this->county}", "gluten free {$this->county}", "gluten free food {$this->county}",
            "gluten free places to eat in {$this->county}", 'gluten free places to eat', 'gluten free cafes',
            'gluten free restaurants', 'gluten free uk', 'places to eat', 'cafes', 'restaurants', 'eating out',
            'catering to coeliac', 'eating out uk', 'gluten free venues', 'gluten free dining',
            'gluten free directory', 'gf food', $this->county,
        ];
    }

    /** @return Attribute<string | null, never> */
    public function image(): Attribute
    {
        return Attribute::get(function () { /** @phpstan-ignore-line */
            try {
                return $this->main_image;
            } catch (Error $exception) { /** @phpstan-ignore-line */
                return null;
            }
        });
    }

    public function link(): string
    {
        return '/' . implode('/', [
            'wheretoeat',
            $this->slug,
        ]);
    }
}