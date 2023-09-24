<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Support\EatingOut\SuggestEdits\SuggestedEditProcessor;
use Illuminate\Support\Facades\Request;

class StoreSuggestedEditAction
{
    public function handle(Eatery $eatery, string $field, mixed $suggestedValue): void
    {
        $editableField = app(SuggestedEditProcessor::class)->resolveEditableField($field, $suggestedValue);

        $eatery->suggestedEdits()->create([
            'field' => $field,
            'value' => $editableField->getSuggestedValue(),
            'ip' => Request::ip(),
        ]);
    }
}
