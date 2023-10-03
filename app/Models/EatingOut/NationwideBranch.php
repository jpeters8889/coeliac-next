<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use App\Concerns\EatingOut\HasEateryDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

/**
 * @property Eatery $eatery
 */
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

    public function link(): string
    {
        return '/' . implode('/', [
            'wheretoeat',
            'nationwide',
            $this->eatery->slug,
            $this->slug,
        ]);
    }

    /**
     * @param  Relation<self>  $query
     * @return Relation<self>
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if (app(Request::class)->wantsJson()) {
            return $query->where('id', $value); /** @phpstan-ignore-line */
        }

        /** @phpstan-ignore-next-line  */
        return $query->where('slug', $value);
    }
}
