<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EateryAttractionRestaurant extends Model
{
    /** @return BelongsTo<Eatery, EateryAttractionRestaurant> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id', 'id');
    }
}
