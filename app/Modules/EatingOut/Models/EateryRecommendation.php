<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $place_name
 * @property string $place_details
 * @property string $place_location
 * @property string $place_web_address
 * @property number $place_venue_type_id
 */
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
