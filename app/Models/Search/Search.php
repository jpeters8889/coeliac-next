<?php

declare(strict_types=1);

namespace App\Models\Search;

use App\Models\SearchHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Search extends Model
{
    /** @return HasOne<SearchAiResponse, $this> */
    public function aiResponse(): HasOne
    {
        return $this->hasOne(SearchAiResponse::class);
    }

    /** @return HasMany<SearchHistory, $this> */
    public function history(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }
}
