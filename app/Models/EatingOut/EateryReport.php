<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EateryReport extends Model
{
    protected $table = 'wheretoeat_place_reports';

    protected $casts = ['completed' => 'bool'];

    /** @return BelongsTo<Eatery, EateryReport> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id');
    }
}
