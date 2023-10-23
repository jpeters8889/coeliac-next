<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Algolia\ScoutExtended\Builder as AlgoliaBuilder;
use App\Concerns\EatingOut\HasEateryDetails;
use App\DataObjects\EatingOut\LatLng;
use App\Support\Helpers;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

/**
 * @property Eatery $eatery
 * @property float | null $distance
 */
class NationwideBranch extends Model
{
    use HasEateryDetails;
    use Searchable;

    protected $table = 'wheretoeat_nationwide_branches';

    protected $appends = ['formatted_address', 'full_location'];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    public static function booted(): void
    {
        static::saving(function (self $eatery) {
            if ( ! $eatery->slug) {
                $eatery->slug = $eatery->generateSlug();
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
        return $this->transform([
            'title' => $this->name . ', ' . $this->town->town,
            'location' => $this->town->town . ', ' . $this->county->county,
            'town' => $this->town->town,
            'county' => $this->county->county,
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
