<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\ReviewMyOrder;

use App\Http\Response\Inertia;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopOrderReviewInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Inertia\Response;

class ShowController
{
    public function __invoke(Inertia $inertia, ShopOrderReviewInvitation $invitation): RedirectResponse|Response
    {
        if ($invitation->review()->count() > 0) {
            return new RedirectResponse(route('shop.review-order.thanks', $invitation));
        }

        /** @var ShopOrder $order */
        $order = $invitation->order;

        /** @var ShopCustomer $customer */
        $customer = $order->customer;

        /** @var Collection<int, ShopOrderItem> $items */
        $items = $order->items->load(['product', 'product.media']);

        return $inertia
            ->title('Review My Order')
            ->doNotTrack()
            ->render('Shop/ReviewMyOrder', [
                'id' => $order->order_key,
                'invitation' => $invitation->id,
                'name' => $customer->name,
                'products' => $items->map(fn (ShopOrderItem $item) => [
                    'id' => $item->product_id,
                    'title' => $item->product_title,
                    'image' => $item->product->main_image,
                    'link' => $item->product->link,
                ]),
            ]);
    }
}
