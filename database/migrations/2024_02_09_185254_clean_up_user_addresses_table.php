<?php

declare(strict_types=1);

use App\Models\Shop\ShopShippingAddress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        try {
            ShopShippingAddress::query()->where('type', 'Billing')->forceDelete();
        } catch (Exception) {
            //
        }

        Schema::table('user_addresses', function (Blueprint $table): void {
            $table->dropColumn('type');
            $table->string('county')->after('town')->nullable();
        });
    }
};
