<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Modules\Shared\Comments\Commentable;
use App\Modules\Shared\Comments\HasComments;
use App\Modules\Shared\Scopes\LiveScope;
use App\Modules\Shared\Support\DisplaysMedia;
use App\Modules\Shared\Support\LinkableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property Carbon $created_at
 * @property Collection<RecipeAllergen> $allergens
 * @property bool $live
 * @property string $title
 * @property string $author
 * @property string $meta_description
 * @property mixed $prep_time
 * @property mixed $cook_time
 * @property string $servings
 * @property string $portion_size
 * @property RecipeNutrition $nutrition
 * @property string $ingredients
 * @property string $body
 * @property string $meta_tags
 * @property Collection<RecipeFeature> $features
 * @property string $method
 * @property string $description
 * @property string $link
 * @property int $id
 * @property Collection $meals
 * @property string $meta_keywords
 * @property string $legacy_slug
 * @property string $slug
 *
 * @method transform(array $array)
 */
class Recipe extends Model implements HasComments, HasMedia
{
    use Commentable;
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;

    use InteractsWithMedia;
    use LinkableModel;

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('social')->singleFile();

        $this->addMediaCollection('primary')->singleFile();

        $this->addMediaCollection('square')->singleFile();

        $this->addMediaCollection('body');
    }

    /** @return BelongsToMany<RecipeAllergen> */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeAllergen::class,
            'recipe_assigned_allergens',
            'recipe_id',
            'allergen_type_id'
        )->withTimestamps();
    }

    /** @return Collection<int, RecipeAllergen> */
    public function containsAllergens(): Collection
    {
        return RecipeAllergen::query()
            ->get()
            ->reject(fn (RecipeAllergen $allergen) => $this->allergens->where('allergen', $allergen->allergen)->count() > 0);
    }

    /** @return BelongsToMany<RecipeFeature> */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeFeature::class,
            'recipe_assigned_features',
            'recipe_id',
            'feature_type_id'
        )->withTimestamps();
    }

    /** @return BelongsToMany<RecipeMeal> */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeMeal::class,
            'recipe_assigned_meals',
            'recipe_id',
            'meal_type_id'
        )->withTimestamps();
    }

    /** @return HasOne<RecipeNutrition> */
    public function nutrition(): HasOne
    {
        return $this->hasOne(RecipeNutrition::class)->latest();
    }
    /** @return Attribute<string, never-return> */
    public function servings(): Attribute
    {
        return Attribute::get(fn () => $this->serving_size);
    }

    /** @return Attribute<string, never-return> */
    public function portionSize(): Attribute
    {
        return Attribute::get(fn () => $this->per);
    }
}
