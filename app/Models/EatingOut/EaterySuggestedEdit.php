<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Eatery $eatery
 * @property int $id
 * @property string $status
 * @property string $field
 * @property string $value
 * @property bool $accepted
 * @property bool $rejected
 */
class EaterySuggestedEdit extends Model
{
    protected $table = 'wheretoeat_suggested_edits';

    protected $casts = [
        'accepted' => 'bool',
        'rejected' => 'bool',
    ];

    /** @return BelongsTo<Eatery, EaterySuggestedEdit> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id');
    }

    //    public static function processorMaps(): array
    //    {
    //        return [
    //            'address' => AddressField::class,
    //            'cuisine' => CuisineField::class,
    //            'features' => FeaturesField::class,
    //            'gf_menu_link' => GfMenuLinkField::class,
    //            'opening_times' => OpeningTimesField::class,
    //            'phone' => PhoneField::class,
    //            'venue_type' => VenueTypeField::class,
    //            'website' => WebsiteField::class,
    //            'info' => InfoField::class,
    //        ];
    //    }

    /** @return Attribute<string, never> */
    public function status(): Attribute
    {
        return Attribute::get(function () {
            if ($this->accepted) {
                return 'Accepted';
            }

            if ($this->rejected) {
                return 'Rejected';
            }

            return 'New';
        });
    }
}
