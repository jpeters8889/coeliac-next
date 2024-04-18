<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Shop\ShopProductPrice;
use Illuminate\Console\Command;

class CleanUpOldProductPricesCommand extends Command
{
    protected $signature = 'coeliac:clean-up-product-prices';

    public function handle(): void
    {
        ShopProductPrice::query()
            ->whereNotNull('end_at')
            ->where('end_at', '<', now())
            ->delete();
    }
}
