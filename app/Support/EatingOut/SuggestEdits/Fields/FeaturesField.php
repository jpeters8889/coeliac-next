<?php

declare(strict_types=1);

namespace App\Support\EatingOut\SuggestEdits\Fields;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryFeature;

class FeaturesField extends EditableField
{
    public static function validationRules(): array
    {
        return [
            'value' => ['required', 'array'],
            'value.*' => ['array'],
            'value.*.key' => ['required', 'numeric', 'exists:wheretoeat_features,id'],
            'value.*.label' => ['required', 'string'],
            'value.*.selected' => ['required', 'boolean'],
        ];
    }

    protected function transformForSaving(): string|int|null
    {
        return (string) json_encode($this->value);
    }

    public function getCurrentValue(Eatery $eatery): ?string
    {
        return EateryFeature::query()
            ->orderBy('feature')
            ->get()
            ->mapWithKeys(fn (EateryFeature $feature) => [
                $feature->feature => collect($eatery->features->pluck('id'))->contains($feature->id),
            ])
            ->toJson();
    }
}
