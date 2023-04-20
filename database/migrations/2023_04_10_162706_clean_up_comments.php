<?php

use App\Modules\Blog\Models\Blog;
use App\Modules\Recipe\Models\Recipe;
use App\Modules\Shared\Models\Comment;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Comment::query()
            ->where('commentable_type', 'Coeliac\Modules\EatingOut\Reviews\Models\Review')
            ->delete();

        Comment::query()
            ->where('commentable_type', 'Coeliac\Modules\Recipe\Models\Recipe')
            ->update(['commentable_type' => Recipe::class]);

        Comment::query()
            ->where('commentable_type', 'Coeliac\Modules\Blog\Models\Blog')
            ->update(['commentable_type' => Blog::class]);
    }
};
