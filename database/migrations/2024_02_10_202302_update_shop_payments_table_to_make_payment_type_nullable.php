<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('shop_payments', function (Blueprint $table): void {
            $table->dropForeign('shop_payments_payment_type_id_foreign');
        });

        Schema::table('shop_payments', function (Blueprint $table): void {
            $table->integer('payment_type_id')->nullable()->change();
        });
    }
};
