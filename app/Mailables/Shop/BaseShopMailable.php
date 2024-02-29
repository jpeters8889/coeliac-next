<?php

declare(strict_types=1);

namespace App\Mailables\Shop;

use App\DataObjects\NotificationRelatedObject;
use App\Infrastructure\MjmlMessage;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class BaseShopMailable
{
    protected string $emailKey = '';

    final public function __construct(protected ShopOrder $order, ?string $emailKey = null)
    {
        $this->emailKey = $emailKey ?? Str::uuid()->toString();
    }

    public static function make(ShopOrder $order, string $emailKey): MjmlMessage
    {
        return (new static($order, $emailKey))->toMail();
    }

    protected function baseData(array $data = []): array
    {
        return array_merge([
            'date' => Carbon::now(),
            'key' => $this->emailKey,
            'order' => $this->order,
            'notifiable' => $this->order->customer,
            'relatedTitle' => 'Products',
            'relatedItems' => ShopProduct::query()
                ->take(3)
                ->inRandomOrder()
                ->get()
                ->map(fn (ShopProduct $product) => new NotificationRelatedObject(
                    title: $product->title,
                    image: $product->main_image,
                    link: $product->link,
                )),
        ], $data);
    }

    abstract public function toMail(): MjmlMessage;
}
