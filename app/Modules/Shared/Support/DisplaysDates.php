<?php

declare(strict_types=1);

namespace App\Modules\Shared\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
trait DisplaysDates
{
    /** @return Attribute<string, never> */
    public function published(): Attribute
    {
        return Attribute::get(function () {
            $date = $this->publish_at ?? $this->created_at;

            if ($date < Carbon::now()->subMonth()) {
                return $date->format('jS F Y');
            }

            return $date->diffForHumans();
        });
    }

    /** @return Attribute<string | null, never> */
    public function lastUpdated(): Attribute
    {
        return Attribute::get(function () {
            $date = $this->publish_at ?? $this->created_at;

            if ($date === $this->updated_at) {
                return null;
            }

            if ($this->updated_at < Carbon::now()->subMonth()) {
                return $this->updated_at->format('jS F Y');
            }

            return $this->updated_at->diffForHumans();
        });
    }
}
