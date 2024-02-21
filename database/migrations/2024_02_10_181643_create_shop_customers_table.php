<?php

declare(strict_types=1);

use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('shop_customers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->timestamps();
        });

        User::query()->lazy()->each(function (User $user): void {
            ShopCustomer::query()->create($user->only(['id', 'name', 'email', 'phone', 'created_at', 'updated_at']));
        });
    }
};
