<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('search_ai_responses', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('search_id');
            $table->integer('blogs');
            $table->integer('recipes');
            $table->integer('eateries');
            $table->integer('shop');
            $table->string('explanation');
            $table->text('location')->nullable();
            $table->timestamps();
        });
    }
};
