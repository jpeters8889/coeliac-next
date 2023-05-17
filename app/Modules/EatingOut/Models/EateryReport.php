<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EateryReport extends Model
{
    protected $table = 'wheretoeat_place_reports';

    /** @return BelongsTo<Eatery, EateryReport> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id');
    }
}
