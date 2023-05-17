<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $feature
 * @property int $id
 * @property int $type_id
 */
class EateryFeature extends Model
{
    protected $table = 'wheretoeat_features';

    /** @return BelongsToMany<Eatery> */
    public function eateries(): BelongsToMany
    {
        return $this->belongsToMany(Eatery::class, 'wheretoeat_assigned_features', 'feature_id', 'wheretoeat_id');
    }
}
