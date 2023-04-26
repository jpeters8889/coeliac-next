<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Modules\Shared\Comments\Commentable;
use App\Modules\Shared\Comments\HasComments;
use App\Modules\Shared\Scopes\LiveScope;
use App\Modules\Shared\Support\DisplaysDates;
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
use Spatie\SchemaOrg\RestrictedDiet;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Recipe as RecipeSchema;

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
 * @property string $legacy_slug
 * @property string $slug
 * @property string $published
 * @property string $lastUpdated
 *
 * @method transform(array $array)
 */
class Recipe extends Model implements HasComments, HasMedia
{
    use Commentable;
    use DisplaysDates;
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;

    use InteractsWithMedia;
    use LinkableModel;

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope());
    }

    public function getRouteKeyName()
    {
        return 'slug';
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

    /** @noinspection PhpParamsInspection */
    public function schema(): RecipeSchema
    {
        /** @var string $url */
        $url = config('app.url');

        return Schema::recipe()
            ->name($this->title)
            ->image($this->main_image)
            ->author(Schema::person()->name('Alison Peters'))
            ->dateModified($this->updated_at)
            ->datePublished($this->created_at)
            ->prepTime($this->formatTimeToIso($this->prep_time)) /** @phpstan-ignore-line */
            ->cookTime($this->formatTimeToIso($this->cook_time)) /** @phpstan-ignore-line */
            ->recipeYield($this->servings)
            ->nutrition(
                Schema::nutritionInformation()
                    ->calories("{$this->nutrition->calories} calories") /** @phpstan-ignore-line */
                    ->carbohydrateContent("{$this->nutrition->carbs} grams") /** @phpstan-ignore-line */
                    ->fatContent("{$this->nutrition->fat} grams") /** @phpstan-ignore-line */
                    ->proteinContent("{$this->nutrition->protein} grams") /** @phpstan-ignore-line */
                    ->sugarContent("{$this->nutrition->sugar} grams") /** @phpstan-ignore-line */
                    ->fiberContent("{$this->nutrition->fibre} grams") /** @phpstan-ignore-line */
                    ->servingSize($this->portion_size)
            )
            ->recipeIngredient(explode("\n", $this->ingredients))
            ->recipeInstructions(explode("\n\n", $this->method))
            ->suitableForDiet($this->richTextSuitableFor())
            ->keywords($this->meta_tags)
            ->recipeCategory('Gluten Free')
            ->recipeCuisine('')
            ->mainEntityOfPage(Schema::webPage()->identifier($url))
            ->publisher(Schema::organization()
                ->name('Coeliac Sanctuary')
                ->logo(Schema::imageObject()->url($url . "/images/logo.svg"))
            );
    }

    protected function richTextSuitableFor(): array
    {
        $suitableFor[] = Schema::restrictedDiet()->identifier(RestrictedDiet::GlutenFreeDiet);

        if ( ! $this->allergens->contains('Dairy')) {
            $suitableFor[] = Schema::restrictedDiet()->identifier(RestrictedDiet::LowLactoseDiet);
        }

        if ($this->nutrition->calories < 400) {
            $suitableFor[] = Schema::restrictedDiet()->identifier(RestrictedDiet::LowCalorieDiet);
        }

        if ($this->features->contains('Vegan')) {
            $suitableFor[] = Schema::restrictedDiet()->identifier(RestrictedDiet::VeganDiet);
        }

        if ($this->features->contains('Vegetarian')) {
            $suitableFor[] = Schema::restrictedDiet()->identifier(RestrictedDiet::VegetarianDiet);
        }

        return $suitableFor;
    }

    protected function formatTimeToIso(string $time): string
    {
        $time = str_ireplace([' and', ' a', ' half'], '', $time);
        $bits = explode(' ', $time);

        if (count($bits) === 4) {
            return "PT{$bits[0]}H{$bits[2]}M";
        }

        if (count($bits) === 2) {
            $unit = 'M';

            if (in_array($bits[1], ['Hour', 'Hours'])) {
                $unit = 'H';
            }

            return "PT{$bits[0]}{$unit}";
        }

        return 'PT';
    }
}
