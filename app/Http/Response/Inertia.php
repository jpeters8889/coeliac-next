<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Actions\GetPopupCtaAction;
use App\Actions\Shop\GetOrderItemsAction;
use App\Actions\Shop\ResolveBasketAction;
use App\Resources\Shop\ShopOrderItemResource;
use App\Support\Helpers;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia as BaseInertia;
use Inertia\LazyProp;
use Inertia\Response;
use Money\Money;

class Inertia
{
    public function __construct()
    {
        BaseInertia::share('meta.baseUrl', config('app.url'));
        BaseInertia::share('meta.title', config('metas.title'));
        BaseInertia::share('meta.description', config('metas.description'));
        BaseInertia::share('meta.tags', config('metas.tags'));
        BaseInertia::share('meta.image', config('metas.image'));

        if (Request::routeIs('shop.product')) {
            BaseInertia::share('productShippingText', config('coeliac.shop.product_postage_description'));
        }

        if ( ! Request::routeIs('shop.*')) {
            $this->loadCta();
        }

        if (Request::hasCookie('basket_token') && ! Request::routeIs('shop.basket.checkout')) {
            $this->includeBasket();
        }
    }

    public function title(string $title): self
    {
        BaseInertia::share('meta.title', $title);

        return $this;
    }

    public function metaDescription(string $description): self
    {
        BaseInertia::share('meta.description', $description);

        return $this;
    }

    public function metaTags(array $tags, bool $merge = true): self
    {
        if ($merge) {
            /** @var string[] $defaultTags */
            $defaultTags = config('metas.tags');

            $tags = array_merge($tags, $defaultTags);
        }

        BaseInertia::share('meta.tags', $tags);

        return $this;
    }

    public function metaImage(string $image): self
    {
        BaseInertia::share('meta.image', $image);

        return $this;
    }

    public function schema(string $schema): self
    {
        BaseInertia::share('meta.schema', $schema);

        return $this;
    }

    public function alternateMetas(array $metas): self
    {
        BaseInertia::share('meta.alternateMetas', $metas);

        return $this;
    }

    public function doNotTrack(): self
    {
        BaseInertia::share('meta.doNotTrack', true);

        return $this;
    }

    /** @param array<string, mixed> | Arrayable<string, mixed> $props */
    public function render(string $component, array|Arrayable $props = []): Response
    {
        return BaseInertia::render($component, $props);
    }

    public function getShared(?string $key = null, mixed $default = null): mixed
    {
        return BaseInertia::getShared($key, $default);
    }

    public function lazy(callable $callback): LazyProp
    {
        return BaseInertia::lazy($callback);
    }

    protected function includeBasket(): void
    {
        /** @var string $token */
        $token = Request::cookie('basket_token');

        $basket = app(ResolveBasketAction::class)->handle($token, false);

        if ( ! $basket) {
            return;
        }

        $items = app(GetOrderItemsAction::class)->handle($basket);

        /** @var Collection<int, ShopOrderItemResource> $collection */
        $collection = app(GetOrderItemsAction::class)->handle($basket)->collection;

        /** @var int $subtotal */
        $subtotal = $collection->map(fn (ShopOrderItemResource $item) => $item->product_price * $item->quantity)->sum();

        BaseInertia::share('basket.items', $items);
        BaseInertia::share('basket.subtotal', Helpers::formatMoney(Money::GBP($subtotal)));
    }

    protected function loadCta(): void
    {
        $popup = app(GetPopupCtaAction::class)->handle();

        if ($popup) {
            BaseInertia::share('popup', [
                'id' => $popup->id,
                'text' => $popup->text,
                'link' => $popup->link,
                'image' => $popup->main_image,
            ]);
        }
    }
}
