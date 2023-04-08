<?php

declare(strict_types=1);

use App\Modules\Recipe\Models\RecipeAllergen;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('recipe_allergens', function (Blueprint $table): void {
            $table->string('slug')->after('allergen')->index();
        });

        RecipeAllergen::query()
            ->get()
            ->each(fn (RecipeAllergen $allergen) => $allergen->update(['slug' => Str::slug($allergen->allergen)]));
    }
};
