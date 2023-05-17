<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string            $county
 * @property EateryCountry $country
 * @property mixed             $slug
 * @property mixed             $reviews_count
 * @property Collection $activeTowns
 * @property int $id
 */
class EateryCounty extends Model
{
    protected $table = 'wheretoeat_counties';

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
}
