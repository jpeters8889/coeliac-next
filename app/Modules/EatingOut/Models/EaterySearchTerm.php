<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property Collection<EaterySearch> $searches
 * @property mixed                        $term
 * @property string $key
 */
class EaterySearchTerm extends Model
{
    protected $table = 'wheretoeat_search_terms';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (EaterySearchTerm $searchTerm) {
            $pass = false;

            while ($pass === false) {
                $key = Str::random(16);

                if (static::query()->where('key', $key)->count() === 0) {
                    $pass = true;
                }
            }

            $searchTerm->key = $key;

            return $searchTerm;
        });
    }

    public function logSearch(): void
    {
        $this->searches()->create();
    }

    /** @return HasMany<EaterySearch> */
    public function searches(): HasMany
    {
        return $this->hasMany(EaterySearch::class, 'search_term_id');
    }
}
