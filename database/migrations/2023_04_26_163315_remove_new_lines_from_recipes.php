<?php

declare(strict_types=1);

use App\Models\Recipes\Recipe;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Recipe::query()->get()->each(function (Recipe $recipe): void {
            $recipe->timestamps = false;
            $recipe->ingredients = str_replace('<br />', "\n", $recipe->ingredients);
            $recipe->method = str_replace('<br />', "\n", $recipe->method);

            $recipe->saveQuietly();
        });
    }
};
