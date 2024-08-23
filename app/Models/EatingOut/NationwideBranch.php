<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Algolia\ScoutExtended\Builder as AlgoliaBuilder;
use App\Concerns\EatingOut\HasEateryDetails;
use App\Concerns\HasOpenGraphImage;
use App\Contracts\HasOpenGraphImageContract;
use App\Contracts\Search\IsSearchable;
use App\DataObjects\EatingOut\LatLng;
use App\Jobs\OpenGraphImages\CreateEateryAppPageOpenGraphImageJob;
use App\Jobs\OpenGraphImages\CreateEateryIndexPageOpenGraphImageJob;
use App\Jobs\OpenGraphImages\CreateEateryMapPageOpenGraphImageJob;
use App\Jobs\OpenGraphImages\CreateEatingOutOpenGraphImageJob;
use App\Support\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

/**
 * @property Eatery $eatery
 */
class NationwideBranch extends Model implements HasOpenGraphImageContract, IsSearchable
{
    use HasEateryDetails;
    use HasOpenGraphImage;
    use Searchable;

    protected $table = 'wheretoeat_nationwide_branches';

    protected $appends = ['formatted_address', 'full_location'];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'live' => 'bool',
    ];

    public static function booted(): void
    {
        static::saving(function (self $eatery) {
            if ( ! $eatery->slug) {
                $eatery->slug = $eatery->generateSlug();
            }

            return $eatery;
        });

        static::saved(function (self $branch): void {
            if (config('coeliac.generate_og_images') === false) {
                return;
            }

            $eatery = $branch->eatery()->withoutGlobalScopes()->firstOrFail();
            $town = $branch->town()->withoutGlobalScopes()->firstOrFail();

            CreateEatingOutOpenGraphImageJob::dispatch($branch);
            CreateEatingOutOpenGraphImageJob::dispatch($eatery);
            CreateEatingOutOpenGraphImageJob::dispatch($town);
            CreateEatingOutOpenGraphImageJob::dispatch($town->county()->withoutGlobalScopes()->firstOrFail());
            CreateEateryAppPageOpenGraphImageJob::dispatch();
            CreateEateryMapPageOpenGraphImageJob::dispatch();
            CreateEateryIndexPageOpenGraphImageJob::dispatch();
        });
    }

    public static function algoliaSearchAroundLatLng(LatLng $latLng, int|float $radius = 2): AlgoliaBuilder
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

    /** @return Builder<self> */
    public static function databaseSearchAroundLatLng(LatLng $latLng, int|float $radius = 2): Builder
    {
        return static::query()
            ->selectRaw('(
                        3959 * acos (
                          cos ( radians(?) )
                          * cos( radians( lat ) )
                          * cos( radians( lng ) - radians(?) )
                          + sin ( radians(?) )
                          * sin( radians( lat ) )
                        )
                     ) AS distance', [
                $latLng->lat,
                $latLng->lng,
                $latLng->lat,
            ])->having('distance', '<=', $radius)
            ->addSelect(['id', 'wheretoeat_id', 'lat', 'lng', 'name'])
            ->orderBy('distance');
    }

    /** @return BelongsTo<Eatery, NationwideBranch> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id');
    }

    public function link(): string
    {
        return '/' . implode('/', [
            'wheretoeat',
            'nationwide',
            $this->eatery->slug,
            $this->slug,
        ]);
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

        /** @phpstan-ignore-next-line  */
        return $query->where('slug', $value);
    }

    public function toSearchableArray(): array
    {
        $this->loadMissing(['town', 'county', 'country']);

        $name = $this->name !== '' ? $this->name : $this->eatery->name;

        return $this->transform([
            'title' => $this->relationLoaded('town') && $this->town ? $name . ', ' . $this->town->town : $name,
            'location' => $this->relationLoaded('town') && $this->relationLoaded('county') && $this->town && $this->county ? $this->town->town . ', ' . $this->county->county : '',
            'town' => $this->relationLoaded('town') && $this->town ? $this->town->town : '',
            'county' => $this->relationLoaded('county') && $this->county ? $this->county->county : '',
            'info' => $this->eatery ? $this->eatery->info : '', /** @phpstan-ignore-line */
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

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function makeAllSearchableUsing(Builder $query)
    {
        return $query->with(['town', 'county', 'country']);
    }

    /** @return HasMany<EateryReport> */
    public function reports(): HasMany
    {
        return $this->hasMany(EateryReport::class, 'branch_id');
    }

    /** @return HasManyThrough<EateryReview> */
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(EateryReview::class, Eatery::class, 'id', 'wheretoeat_id', 'id', 'id');
    }

    /** @return HasManyThrough<EateryReviewImage> */
    public function reviewImages(): HasManyThrough
    {
        return $this->hasManyThrough(EateryReviewImage::class, Eatery::class, 'id', 'wheretoeat_id', 'id', 'id');
    }

    /** @return Attribute<string, never> */
    public function fullName(): Attribute
    {
        return Attribute::get(function () {
            if ($this->name) {
                return "{$this->name} ({$this->eatery->name}) - {$this->full_location}";
            }

            return "{$this->eatery->name} - {$this->full_location}";
        });
    }

    /** @return Attribute<string | null, never> */
    public function averageRating(): Attribute
    {
        return Attribute::get(fn () => $this->eatery->average_rating);
    }
}
