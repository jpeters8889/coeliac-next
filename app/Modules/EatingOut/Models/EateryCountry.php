<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $country
 */
class EateryCountry extends Model
{
    protected $table = 'wheretoeat_countries';

    /** @return HasMany<Eatery> */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'country_id');
    }

    /** @return HasMany<EateryCounty> */
    public function counties(): HasMany
    {
        return $this->hasMany(EateryCounty::class, 'country_id');
    }
}
