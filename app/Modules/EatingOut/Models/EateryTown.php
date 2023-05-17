<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property string $town
 * @property EateryCounty $county
 * @property string $slug
 * @property Collection $liveEateries
 */
class EateryTown extends Model
{
    protected $table = 'wheretoeat_towns';

    protected static function booted(): void
    {
        static::creating(static function (self $town) {
            if ( ! $town->slug) {
                $town->slug = Str::slug($town->town);
                $town->legacy = $town->slug;
            }

            return $town;
        });
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

    /** @return BelongsTo<EateryCounty, EateryTown> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(EateryCounty::class, 'county_id');
    }
}
