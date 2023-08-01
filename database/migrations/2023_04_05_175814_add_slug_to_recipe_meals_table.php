<?php

declare(strict_types=1);

use App\Models\Recipes\RecipeMeal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('recipe_meals', function (Blueprint $table): void {
            $table->string('slug')->after('meal')->index();
        });

        RecipeMeal::query()
            ->get()
            ->each(fn (RecipeMeal $meal) => $meal->update(['slug' => Str::slug($meal->meal)]));
    }
};
