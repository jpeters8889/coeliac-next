<?php

declare(strict_types=1);

use App\Models\Recipes\RecipeFeature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('recipe_features', function (Blueprint $table): void {
            $table->string('slug')->after('feature')->index();
        });

        RecipeFeature::query()
            ->get()
            ->each(fn (RecipeFeature $feature) => $feature->update(['slug' => Str::slug($feature->feature)]));
    }
};
