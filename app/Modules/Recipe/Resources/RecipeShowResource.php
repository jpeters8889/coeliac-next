<?php

namespace App\Modules\Recipe\Resources;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeAllergen;
use App\Modules\Recipe\Models\RecipeFeature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin Recipe */
class RecipeShowResource extends JsonResource
{
    /** @return array{id: number, title: string, image: string, published: string, updated: string, description: string, body: string} */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->main_image,
            'square_image' => $this->square_image,
            'published' => $this->published,
            'updated' => $this->lastUpdated,
            'author' => $this->author,
            'description' => $this->description,
            'ingredients' => Str::markdown($this->ingredients),
            'method' => Str::markdown($this->method),
            'features' => $this->features->transform(fn(RecipeFeature $feature) => [
                'feature' => $feature->feature,
                'slug' => $feature->slug,
            ])->values(),
            'allergens' => $this->containsAllergens()->transform(fn(RecipeAllergen $allergen) => [
                'allergen' => $allergen->allergen,
                'slug' => $allergen->slug,
            ])->values(),
            'timing' => [
                'prep_time' => $this->prep_time,
                'cook_time' => $this->cook_time,
            ],
            'nutrition' => [
                'servings' => $this->servings,
                'portion_size' => $this->portion_size,
                'calories' => $this->nutrition->calories,
                'carbs' => $this->nutrition->carbs,
                'fibre' => $this->nutrition->fibre,
                'fat' => $this->nutrition->fat,
                'sugar' => $this->nutrition->sugar,
                'protein' => $this->nutrition->protein,
            ],
        ];
    }
}
