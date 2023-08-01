<?php

declare(strict_types=1);

use App\Models\Blogs\Blog;
use App\Models\Comments\Comment;
use App\Models\Recipes\Recipe;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
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
