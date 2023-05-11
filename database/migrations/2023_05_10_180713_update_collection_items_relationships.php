<?php

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('UPDATE collection_items SET item_type = "App\\\Modules\\\Recipe\\\Models\\\Recipe" WHERE item_type = "Coeliac\\\Modules\\\Recipe\\\Models\\\Recipe"');
        DB::statement('UPDATE collection_items SET item_type = "App\\\Modules\\\Blog\\\Models\\\Blog" WHERE item_type = "Coeliac\\\Modules\\\Blog\\\Models\\\Blog"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
