<?php

declare(strict_types=1);

namespace App\Http\Controllers\Recipes;

use App\Models\Recipes\Recipe;
use Illuminate\Contracts\View\View;

class RecipePrintController
{
    public function __invoke(Recipe $recipe): View
    {
        return view('recipe-print', ['recipe' => $recipe]);
    }
}
