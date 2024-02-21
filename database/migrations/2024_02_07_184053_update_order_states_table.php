<?php

declare(strict_types=1);

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrderState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class() extends Migration
{
    public function up(): void
    {
        foreach (OrderState::cases() as $state) {
            ShopOrderState::query()->find($state->value)?->update(['state' => Str::title($state->name)]);
        }
    }
};
