<?php

declare(strict_types=1);

namespace App\Support\EatingOut\SuggestEdits;

use App\Models\EatingOut\EaterySuggestedEdit;
use App\Support\EatingOut\SuggestEdits\Fields\EditableField;
use Illuminate\Support\Arr;
use RuntimeException;

class SuggestedEditProcessor
{
    public function resolveEditableField(string $field, mixed $value): EditableField
    {
        /** @var class-string<EditableField> $class */
        $class = Arr::get(EaterySuggestedEdit::processorMaps(), $field);

        throw_if( ! $class, new RuntimeException('Not a valid field'));

        return $class::make($value);
    }
}
