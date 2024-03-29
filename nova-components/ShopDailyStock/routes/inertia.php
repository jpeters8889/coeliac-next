<?php

declare(strict_types=1);

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

Route::get('/', function (NovaRequest $request) {
    $items = [];

    ShopOrder::query()
        ->whereIn('state_id', [OrderState::PAID, OrderState::READY])
        ->with(['items', 'items.product', 'items.variant', 'items.product.categories'])
        ->get()
        ->each(static function (ShopOrder $order) use (&$items): void {
            $order->items->each(static function (ShopOrderItem $item) use (&$items): void {
                if (array_key_exists($item->variant->id, $items)) {
                    $items[$item->variant->id]['quantity'] += $item->quantity;

                    return;
                }

                $items[$item->variant->id] = [
                    'quantity' => $item->quantity,
                    'item' => $item->makeVisible(['product', 'variant', 'product_title']),
                ];
            });
        });

    $return = [];

    foreach ($items as $product) {
        if ( ! array_key_exists($product['item']->product->categories[0]->title, $return)) {
            $return[$product['item']->product->categories[0]->title] = [];
        }

        $return[$product['item']->product->categories[0]->title][$product['item']->product_title] = $product['quantity'];
    }

    return inertia('ShopDailyStock', [
        'items' => $return,
    ]);
});
