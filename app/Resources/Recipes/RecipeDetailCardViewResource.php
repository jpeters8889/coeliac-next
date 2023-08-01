<?php

declare(strict_types=1);

namespace App\Resources\Recipes;

use App\Models\Recipes\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Recipe */
class RecipeDetailCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, square_image: string|null, date: string, description: string, features: Collection<int,Model>, nutrition: array{calories: string, servings: string, portion_size: string}} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->main_image,
            'square_image' => $this->square_image,
            'date' => $this->published,
            'description' => $this->meta_description,
            'features' => $this->features->only(['feature']),
            'nutrition' => [
                'calories' => $this->nutrition->calories,
                'servings' => $this->servings,
                'portion_size' => $this->portion_size,
            ],
        ];
    }
}
