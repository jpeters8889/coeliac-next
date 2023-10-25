<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Algolia\ScoutExtended\Builder as AlgoliaBuilder;
use App\Concerns\EatingOut\HasEateryDetails;
use App\DataObjects\EatingOut\LatLng;
use App\Scopes\LiveScope;
use App\Support\Helpers;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * @property string $info
 * @property Collection<int, EateryAttractionRestaurant> $restaurants
 * @property string | null $website
 * @property EateryCuisine | null $cuisine
 * @property string | null $phone
 * @property EateryCountry $country
 * @property int $type_id
 * @property int $reviews_count
 * @property Collection<int, EateryFeature> $features
 * @property Collection<int, EateryReview> $reviews
 * @property EateryType $type
 * @property EateryVenueType $venueType
 * @property string $full_name
 * @property string $gf_menu_link
 * @property EateryOpeningTimes | null $openingTimes
 * @property int $county_id
 * @property string | null $average_rating
 * @property int | null $rating
 * @property int | null $rating_count
 * @property int | null $average_expense
 * @property bool $has_been_rated
 * @property float | null $distance
 *
 * @method transform(array $array)
 */
class Eatery extends Model
{
    use HasEateryDetails;
    use Searchable;

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'live' => 'bool',
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

    public static function searchAroundLatLng(LatLng $latLng, int $radius = 2): AlgoliaBuilder
    {
        $params = [
            'aroundLatLng' => $latLng->toString(),
            'aroundRadius' => Helpers::milesToMeters($radius),
            'getRankingInfo' => true,
        ];

        /** @var AlgoliaBuilder $searcher */
        $searcher = static::search();

        return $searcher->with($params);
    }

    /**
     * @param  Relation<self>  $query
     * @return Relation<self>
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if (app(Request::class)->wantsJson()) {
            return $query->where('id', $value); /** @phpstan-ignore-line */
        }

        if (app(Request::class)->route('town')) {
            /** @var EateryTown $town | string */
            $town = app(Request::class)->route('town');

            if ( ! $town instanceof EateryTown) {
                $town = EateryTown::query()->where('slug', $town)->firstOrFail();
            }

            return $town->liveEateries()->where('slug', $value);
        }

        /** @phpstan-ignore-next-line  */
        return $query->where('slug', $value);
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

    /** @return HasMany<NationwideBranch> */
    public function nationwideBranches(): HasMany
    {
        return $this->hasMany(NationwideBranch::class, 'wheretoeat_id');
    }

    /** @return HasOne<NationwideBranch> */
    public function branch(): HasOne
    {
        return $this->hasOne(NationwideBranch::class, 'wheretoeat_id');
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

    /** @return HasOne<EateryReview> */
    public function adminReview(): HasOne
    {
        return $this->hasOne(EateryReview::class, 'wheretoeat_id', 'id')
            ->where('admin_review', true)
            ->latest();
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

    /** @return HasMany<EateryReviewImage> */
    public function approvedReviewImages(): HasMany
    {
        return $this->hasMany(EateryReviewImage::class, 'wheretoeat_id', 'id')
            ->whereRelation('review', 'approved', true);
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

    /** @return HasMany<EaterySuggestedEdit> */
    public function suggestedEdits(): HasMany
    {
        return $this->hasMany(EaterySuggestedEdit::class, 'wheretoeat_id', 'id');
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
                'value' => (string) $average,
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

            return (string) Arr::average($this->reviews->pluck('rating')->toArray());
        });
    }

    /** @return Attribute<string | null, never> */
    public function fullName(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('town')) {
                return null;
            }

            if (Str::lower($this->town->town) === 'nationwide') {
                return "{$this->name} Nationwide Chain";
            }

            return implode(', ', [
                $this->name,
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
     * @param  Builder<Eatery>  $builder
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
     * @param  Builder<Eatery>  $builder
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
     * @param  Builder<Eatery>  $builder
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

    public function keywords(): array
    {
        return [
            $this->name, $this->full_name, "{$this->name} gluten free",
            "gluten free {$this->town}", "coeliac {$this->town} eateries", "gluten free {$this->town} eateries",
            'gluten free places to eat in the uk', "gluten free places to eat in {$this->town}",
            'gluten free places to eat', 'gluten free cafes', 'gluten free restaurants', 'gluten free uk',
            'places to eat', 'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk',
            'gluten free venues', 'gluten free dining', 'gluten free directory', 'gf food',
        ];
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->relationLoaded('town') ? $this->name . ', ' . $this->town->town : $this->name,
            'location' => $this->relationLoaded('town') && $this->relationLoaded('county') ? $this->town->town . ', ' . $this->county->county : '',
            'town' => $this->relationLoaded('town') ? $this->town->town : '',
            'county' => $this->relationLoaded('county') ? $this->county->county : '',
            'address' => $this->address,
            '_geoloc' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->live;
    }

    /** @return Attribute<float | null, callable(float): void> */
    public function distance(): Attribute
    {
        return Attribute::make(
            get: fn () => Arr::get($this->attributes, 'distance'),
            set: fn ($distance) => $this->attributes['distance'] = $distance,
        );
    }
}
