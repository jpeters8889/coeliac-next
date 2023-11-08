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
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $town
 * @property EateryCounty $county
 * @property string $slug
 * @property Collection $liveEateries
 * @property Collection $eateries
 */
class EateryTown extends Model implements HasMedia
{
    use DisplaysMedia;
    use InteractsWithMedia;

    protected $table = 'wheretoeat_towns';

    protected static function booted(): void
    {
        static::addGlobalScope(
            'hasPlaces',
            fn (Builder $builder) => $builder
                ->whereHas('liveEateries')
                ->orWhereHas('liveBranches')
        );

        static::creating(static function (self $town) {
            if ( ! $town->slug) {
                $town->slug = Str::slug($town->town);
                $town->legacy = $town->slug;
            }

            return $town;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /** @return HasMany<Eatery> */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'town_id');
    }

    /** @return HasMany<Eatery> */
    public function liveEateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'town_id')->where('live', true);
    }

    /** @return HasMany<NationwideBranch> */
    public function liveBranches(): HasMany
    {
        return $this->hasMany(NationwideBranch::class, 'town_id')->where('live', true);
    }

    /** @return BelongsTo<EateryCounty, EateryTown> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(EateryCounty::class, 'county_id');
    }

    public function link(): string
    {
        return '/' . implode('/', [
            'wheretoeat',
            $this->county->slug,
            $this->slug,
        ]);
    }

    public function keywords(): array
    {
        return [
            "gluten free {$this->town}", "coeliac {$this->town} eateries", "gluten free {$this->town} eateries",
            'gluten free places to eat in the uk', "gluten free places to eat in {$this->town}",
            'gluten free places to eat', 'gluten free cafes', 'gluten free restaurants', 'gluten free uk',
            'places to eat', 'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk',
            'gluten free venues', 'gluten free dining', 'gluten free directory', 'gf food',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary')->singleFile();
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
}
