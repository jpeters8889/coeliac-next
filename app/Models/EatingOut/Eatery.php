<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use App\Scopes\LiveScope;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * @property string $name
 * @property EateryTown $town
 * @property EateryCounty $county
 * @property string $info
 * @property string $address
 * @property int $lat
 * @property int $lng
 * @property bool $live
 * @property int $id
 * @property Collection<EateryAttractionRestaurant> $restaurants
 * @property string | null $website
 * @property EateryCuisine | null $cuisine
 * @property string | null $phone
 * @property EateryCountry $country
 * @property int $type_id
 * @property int $reviews_count
 * @property Collection<EateryFeature> $features
 * @property Collection<EateryReview> $reviews
 * @property EateryType $type
 * @property string $full_location
 * @property EateryVenueType | null $venueType
 * @property null|string $slug
 * @property number $town_id
 * @property string $full_name
 * @property string $gf_menu_link
 * @property EateryOpeningTimes | null $openingTimes
 * @property int $county_id
 * @property string | null $average_rating
 * @property int | null $rating
 * @property int | null $rating_count
 *
 * @method transform(array $array)
 */
class Eatery extends Model
{
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    protected $table = 'wheretoeat';

    public static function booted(): void
    {
        static::addGlobalScope(new LiveScope());

        static::saving(function (self $eatery) {
            if ( ! $eatery->slug) {
                $eatery->slug = $eatery->generateSlug();
            }

            if ($eatery->type_id === 3) {
                $eatery->venue_type_id = 26;
            }

            if ( ! $eatery->cuisine_id) {
                $eatery->cuisine_id = 1;
            }

            return $eatery;
        });
    }

    public function generateSlug(): string
    {
        if ($this->slug) {
            return $this->slug;
        }

        return Str::of($this->name)
            ->when(
                $this->hasDuplicateNameInTown(),
                fn (Stringable $str) => $str->append(' ' . $this->eateryPostcode()),
            )
            ->slug()
            ->toString();
    }

    protected function hasDuplicateNameInTown(): bool
    {
        return self::query()
            ->where('town_id', $this->town_id)
            ->where('name', $this->name)
            ->where('live', 1)
            ->count() > 1;
    }

    protected function eateryPostcode(): string
    {
        $address = explode('<br />', $this->address);

        return array_pop($address);
    }

    public function link(): string
    {
        return '/' . implode('/', [
            'wheretoeat',
            $this->county->slug,
            $this->town->slug,
            $this->slug,
        ]);
    }

    /** @return BelongsTo<EateryCounty, Eatery> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(EateryCounty::class, 'county_id');
    }

    /** @return BelongsTo<EateryCountry, Eatery> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(EateryCountry::class, 'country_id');
    }

    /** @return HasOne<EateryCuisine> */
    public function cuisine(): HasOne
    {
        return $this->hasOne(EateryCuisine::class, 'id', 'cuisine_id');
    }

    /** @return BelongsToMany<EateryFeature> */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            EateryFeature::class,
            'wheretoeat_assigned_features',
            'wheretoeat_id',
            'feature_id'
        )->withTimestamps();
    }

    /** @return HasOne<EateryOpeningTimes> */
    public function openingTimes(): HasOne
    {
        return $this->hasOne(EateryOpeningTimes::class, 'wheretoeat_id', 'id');
    }

    /** @return HasMany<EateryReport> */
    public function reports(): HasMany
    {
        return $this->hasMany(EateryReport::class, 'wheretoeat_id');
    }

    /** @return HasMany<EateryAttractionRestaurant> */
    public function restaurants(): HasMany
    {
        return $this->hasMany(EateryAttractionRestaurant::class, 'wheretoeat_id', 'id');
    }

    /** @return HasMany<EateryReview> */
    public function reviews(): HasMany
    {
        return $this->hasMany(EateryReview::class, 'wheretoeat_id', 'id');
    }

    /** @return HasMany<EateryReviewImage> */
    public function reviewImages(): HasMany
    {
        return $this->hasMany(EateryReviewImage::class, 'wheretoeat_id', 'id');
    }

    /** @return BelongsTo<EateryTown, Eatery> */
    public function town(): BelongsTo
    {
        return $this->belongsTo(EateryTown::class, 'town_id');
    }

    /** @return HasOne<EateryType> */
    public function type(): HasOne
    {
        return $this->hasOne(EateryType::class, 'id', 'type_id');
    }

    /** @return HasOne<EateryVenueType> */
    public function venueType(): HasOne
    {
        return $this->hasOne(EateryVenueType::class, 'id', 'venue_type_id');
    }

    /** @return Attribute<array{value: string, label: string} | null, never> */
    public function averageExpense(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('reviews')) {
                return null;
            }

            $reviewsWithHowExpense = array_filter($this->reviews->flatten()->pluck('how_expensive')->toArray());

            if (count($reviewsWithHowExpense) === 0) {
                return null;
            }

            $average = round(Arr::average($reviewsWithHowExpense));

            return [
                'value' => (string)$average,
                'label' => EateryReview::HOW_EXPENSIVE_LABELS[$average],
            ];
        });
    }

    /** @return Attribute<string | null, never> */
    public function averageRating(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('reviews')) {
                return null;
            }

            return (string)Arr::average($this->reviews->pluck('rating')->toArray());
        });
    }

    /** @return Attribute<string, never> */
    public function formattedAddress(): Attribute
    {
        return Attribute::get(fn () => Str::of($this->address)->explode('<br />')->join(', '));
    }

    /** @return Attribute<string | null, never> */
    public function fullName(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('town')) {
                return null;
            }

            if (Str::lower($this->town->town) === 'nationwide') {
                return "{$this->name}, Nationwide";
            }

            return implode(', ', [
                $this->name,
                $this->town->town,
                $this->county->county,
                $this->country->country,
            ]);
        });
    }

    /** @return Attribute<string | null, never> */
    public function fullLocation(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('town')) {
                return null;
            }

            if (Str::lower($this->town->town) === 'nationwide') {
                return "{$this->name}, Nationwide";
            }

            return implode(', ', [
                $this->town->town,
                $this->county->county,
                $this->country->country,
            ]);
        });
    }

    /** @return Attribute<bool, never> */
    public function hasBeenRated(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('reviews')) {
                return false;
            }

            return $this->reviews
                ->where('ip', Container::getInstance()->make(Request::class)->ip())
                ->count() > 0;
        });
    }

    /** @return Attribute<string | null, never> */
    public function typeDescription(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('type')) {
                return null;
            }

            return $this->type->name;
        });
    }

    /**
     * @param Builder<Eatery> $builder
     * @return Builder<Eatery>
     */
    public function scopeHasCategories(Builder $builder, array $categories): Builder
    {
        /** @var Closure(Builder<Eatery>): Builder<Eatery> $closure */
        $closure = fn (Builder $builder) => Arr::map(
            $categories,
            fn ($category) => $builder->orWhereRelation('type', 'type', $category)
        );

        return $builder->where($closure);
    }

    /**
     * @param Builder<Eatery> $builder
     * @return Builder<Eatery>
     */
    public function scopeHasVenueTypes(Builder $builder, array $venueTypes): Builder
    {
        /** @var Closure(Builder<Eatery>): Builder<Eatery> $closure */
        $closure = fn (Builder $builder) => Arr::map(
            $venueTypes,
            fn ($venueType) => $builder->orWhereRelation('venueType', 'slug', $venueType)
        );

        return $builder->where($closure);
    }

    /**
     * @param Builder<Eatery> $builder
     * @return Builder<Eatery>
     */
    public function scopeHasFeatures(Builder $builder, array $features): Builder
    {
        /** @var Closure(Builder<Eatery>): Builder<Eatery> $closure */
        $closure = fn (Builder $builder) => Arr::map(
            $features,
            fn ($feature) => $builder->orWhereRelation('features', 'slug', $feature)
        );

        return $builder->where($closure);
    }
}
