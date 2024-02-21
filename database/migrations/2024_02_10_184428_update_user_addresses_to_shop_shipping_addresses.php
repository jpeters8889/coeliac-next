<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table): void {
            $table->dropForeign('shop_orders_user_address_id_foreign');
            $table->renameColumn('user_address_id', 'shipping_address_id');
        });

        Schema::table('user_addresses', function (Blueprint $table): void {
            $table->rename('shop_shipping_addresses');
        });
    }
};
