<?php

use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Blog::query()->get()->each(function (Blog $blog) {
            $blog->timestamps = false;
            $blog->body = str_replace('<br />', "\n", $blog->body);

            $blog->saveQuietly();
        });
    }
};
