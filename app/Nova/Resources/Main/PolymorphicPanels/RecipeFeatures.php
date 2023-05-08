<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main\PolymorphicPanels;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeFeature;
use Jpeters8889\PolymorphicPanel\PolymorphicResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;

class RecipeFeatures implements PolymorphicResource
{
    public function fields(): array
    {
        return RecipeFeature::query()
            ->get()
            ->map(fn (RecipeFeature $feature) => Boolean::make(Str::title($feature->feature)))
            ->toArray();
    }

    public function relationship(): string
    {
        return 'features';
    }

    public function check($key, Collection $relationship): bool
    {
        return $relationship
            ->filter(fn (RecipeFeature $feature): bool => $feature->feature === Str::headline($key)) /** @phpstan-ignore-line  */
            ->count() === 1;
    }

    /** @param Recipe $model */
    public function set(Collection $values, Model $model): void
    {
        /** @var callable $callback */
        $callback = fn (RecipeFeature $feature) => $model->features()->detach($feature);

        $model->features->each($callback);

        $values->map(fn ($value) => filter_var($value, FILTER_VALIDATE_BOOL))
            ->filter(fn ($value) => $value === true)
            ->map(fn ($value, $key) => RecipeFeature::query()->where('feature', Str::headline($key))->firstOrFail()->id)
            ->each(fn ($id) => $model->features()->attach($id));
    }
}
