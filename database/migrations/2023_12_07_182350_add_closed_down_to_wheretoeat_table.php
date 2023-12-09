<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('wheretoeat', function (Blueprint $table): void {
            $table->boolean('closed_down')->after('live')->default(false);
        });

        DB::raw('update wheretoeat set closed_down = not live');
    }
};
