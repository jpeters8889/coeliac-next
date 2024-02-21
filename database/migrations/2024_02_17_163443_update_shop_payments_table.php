<?php

declare(strict_types=1);

use App\Models\Shop\ShopPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_payments', function (Blueprint $table): void {
            $table->string('payment_type_id')->nullable()->change();
        });

        ShopPayment::query()
            ->where('payment_type_id', '1')
            ->update(['payment_type_id' => 'stripe', 'updated_at' => DB::raw('updated_at')]);

        ShopPayment::query()
            ->where('payment_type_id', '2')
            ->update(['payment_type_id' => 'paypal', 'updated_at' => DB::raw('updated_at')]);

        ShopPayment::query()
            ->where('payment_type_id', '3')
            ->update(['payment_type_id' => 'etsy', 'updated_at' => DB::raw('updated_at')]);
    }
};
