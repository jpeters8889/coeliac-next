<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_products', function (Blueprint $table): void {
            $table->string('variant_title')->default('Option')->after('shipping_method_id');
        });
    }
};
