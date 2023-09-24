<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $cuisine
 * @property int $id
 */
class EateryCuisine extends Model
{
    protected $table = 'wheretoeat_cuisines';

    /** @return HasMany<Eatery> */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class, 'cuisine_id');
    }
}
