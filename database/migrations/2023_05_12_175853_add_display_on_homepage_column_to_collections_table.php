<?php

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
        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('display_on_homepage')
                ->default(false)
                ->after('publish_at');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dateTime('remove_from_homepage')
                ->nullable()
                ->default(null)
                ->after('display_on_homepage');
        });
    }
};
