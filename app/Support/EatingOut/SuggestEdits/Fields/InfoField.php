<?php

declare(strict_types=1);

namespace App\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;

class InfoField extends EditableField
{
    public function getCurrentValue(Eatery $eatery): ?string
    {
        return '';
    }
}
