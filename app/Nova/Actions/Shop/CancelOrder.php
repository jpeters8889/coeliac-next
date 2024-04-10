<?php

declare(strict_types=1);

namespace App\Nova\Actions\Shop;

use App\Actions\Shop\CancelOrderAction;
use App\Models\Shop\ShopOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;

/**
 * @codeCoverageIgnore
 */
class CancelOrder extends DestructiveAction implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(function (ShopOrder $order): void {
            app(CancelOrderAction::class)->handle($order);
        });
    }
}
