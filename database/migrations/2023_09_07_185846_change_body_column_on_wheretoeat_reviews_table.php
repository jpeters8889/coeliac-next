<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('wheretoeat_reviews', function (Blueprint $table): void {
            $table->renameColumn('body', 'review');
        });
    }
};