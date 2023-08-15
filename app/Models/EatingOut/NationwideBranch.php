<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use App\Concerns\EatingOut\HasEateryDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NationwideBranch extends Model
{
    use HasEateryDetails;

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

    /** @return BelongsTo<Eatery, NationwideBranch> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id');
    }
}
