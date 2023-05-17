<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string $venue_type
 * @property int $id
 */
class EateryVenueType extends Model
{
    protected $table = 'wheretoeat_venue_types';

    /** @return HasMany<Eatery> */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'venue_type_id');
    }
}
