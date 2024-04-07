<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table): void {
            $table->string('payment_intent_secret')->nullable()->default(null)->after('payment_intent_id');
        });
    }
};
