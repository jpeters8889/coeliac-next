<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EateryRecommendation extends Model
{
    protected $table = 'wheretoeat_place_recommendation';

    protected $casts = [
        'completed' => 'bool',
    ];

    /** @return BelongsTo<EateryVenueType, EateryRecommendation> */
    public function venueType(): BelongsTo
    {
        return $this->belongsTo(EateryVenueType::class, 'place_venue_type_id');
    }
}
