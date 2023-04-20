<?php

namespace App\Modules\Shared\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/** @mixin Model */
trait DisplaysDates
{
    /** @return Attribute<string, null> */
    public function published(): Attribute
    {
        return Attribute::get(function () {
            if ($this->created_at < Carbon::now()->subMonth()) {
                return $this->created_at->format('jS F Y');
            }

            return $this->created_at->diffForHumans();
        });
    }

    /** @return Attribute<string, null> */
    public function lastUpdated(): Attribute
    {
        return Attribute::get(function() {
            if($this->created_at === $this->updated_at) {
                return null;
            }

            if ($this->updated_at < Carbon::now()->subMonth()) {
                return $this->updated_at->format('jS F Y');
            }

            return $this->updated_at->diffForHumans();
        });
    }
}