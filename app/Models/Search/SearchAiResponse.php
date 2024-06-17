<?php

declare(strict_types=1);

namespace App\Models\Search;

use App\DataObjects\Search\SearchAiResponse as SearchAiResponseDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchAiResponse extends Model
{
    /** @return BelongsTo<Search, self> */
    protected function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }

    public function toDto(): SearchAiResponseDto
    {
        return new SearchAiResponseDto(
            shop: $this->shop,
            eatingOut: $this->eateries,
            blogs: $this->blogs,
            recipes: $this->recipes,
            reasoning: $this->explanation,
            location: $this->location,
        );
    }
}
