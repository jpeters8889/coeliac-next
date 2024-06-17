<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Search\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    /** @return BelongsTo<Search, self> */
    protected function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }
}
