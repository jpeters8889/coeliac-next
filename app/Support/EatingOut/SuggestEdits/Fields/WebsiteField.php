<?php

declare(strict_types=1);

namespace App\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;

class WebsiteField extends EditableField
{
    public static function validationRules(): array
    {
        return ['required', 'url'];
    }

    public function getCurrentValue(Eatery $eatery): ?string
    {
        return $eatery->website;
    }
}
