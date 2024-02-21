<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_shipping_addresses', function (Blueprint $table): void {
            $table->dropForeign('user_addresses_user_id_foreign');

            $table->renameColumn('user_id', 'customer_id');
        });
    }
};
