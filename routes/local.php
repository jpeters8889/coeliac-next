<?php

declare(strict_types=1);

use App\DataObjects\NotificationRelatedObject;
use App\Enums\Shop\OrderState;
use App\Models\Comments\Comment;
use App\Models\Comments\CommentReply;
use App\Models\EatingOut\EateryReview;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Spatie\Mjml\Mjml;

Route::get('/mail/shop/order-confirmed/{orderId?}', function (?int $orderId = null): string {
    $order = ShopOrder::query()
        ->where('state_id', OrderState::PAID)
        ->with(['items', 'items.product.media', 'payment', 'customer', 'address'])
        ->when(
            $orderId,
            fn (Builder $builder) => $builder->findOrFail($orderId),
            fn (Builder $builder) => $builder->latest()->first(),
        );

    $content = view('mailables.mjml.shop.order-complete', [
        'key' => 'foo',
        'date' => now(),
        'order' => $order,
        'reason' => 'as confirmation to an order placed in the Coeliac Sanctuary Shop.',
        'notifiable' => $order->customer,
        'relatedTitle' => 'products',
        'relatedItems' => ShopProduct::query()->take(3)->inRandomOrder()->get()->map(fn (ShopProduct $product) => new NotificationRelatedObject(
            title: $product->title,
            image: $product->main_image,
            link: $product->link,
        )),
    ])->render();

    return Mjml::new()->toHtml($content);
});

Route::get('/mail/eating-out/review-approved/{id?}', function (?int $id = null): string {
    $eateryReview = EateryReview::query()
        ->where('approved', true)
        ->whereNotNull('name')
        ->whereNotNull('email')
        ->with(['eatery'])
        ->when(
            $id,
            fn (Builder $builder) => $builder->findOrFail($id),
            fn (Builder $builder) => $builder->latest()->first(),
        );

    $content = view('mailables.mjml.eating-out.review-approved', [
        'key' => 'foo',
        'date' => now(),
        'eateryReview' => $eateryReview,
        'reason' => 'as confirmation to an order placed in the Coeliac Sanctuary Shop.',
        'email' => $eateryReview->email,
        'relatedTitle' => 'products',
        'relatedItems' => ShopProduct::query()->take(3)->inRandomOrder()->get()->map(fn (ShopProduct $product) => new NotificationRelatedObject(
            title: $product->title,
            image: $product->main_image,
            link: $product->link,
        )),
    ])->render();

    return Mjml::new()->toHtml($content);
});

Route::get('/mail/comment-approved/{id?}', function (?int $id = null): string {
    $comment = Comment::query()
        ->where('approved', true)
        ->with(['commentable'])
        ->when(
            $id,
            fn (Builder $builder) => $builder->findOrFail($id),
            fn (Builder $builder) => $builder->latest()->first(),
        );

    $content = view('mailables.mjml.comment-approved', [
        'key' => 'foo',
        'date' => now(),
        'comment' => $comment,
        'reason' => 'to let you know your comment on Coeliac Sanctuary has been approved.',
        'email' => $comment->email,
        'relatedTitle' => 'products',
        'relatedItems' => ShopProduct::query()->take(3)->inRandomOrder()->get()->map(fn (ShopProduct $product) => new NotificationRelatedObject(
            title: $product->title,
            image: $product->main_image,
            link: $product->link,
        )),
    ])->render();

    return Mjml::new()->toHtml($content);
});

Route::get('/mail/comment-reply/{id?}', function (?int $id = null): string {
    $reply = CommentReply::query()
        ->with(['comment', 'comment.commentable'])
        ->when(
            $id,
            fn (Builder $builder) => $builder->findOrFail($id),
            fn (Builder $builder) => $builder->latest()->first(),
        );

    $content = view('mailables.mjml.comment-replied', [
        'key' => 'foo',
        'date' => now(),
        'reply' => $reply,
        'reason' => 'to let you know your comment on Coeliac Sanctuary has been replied to.',
        'email' => $reply->comment->email,
        'relatedTitle' => 'products',
        'relatedItems' => ShopProduct::query()->take(3)->inRandomOrder()->get()->map(fn (ShopProduct $product) => new NotificationRelatedObject(
            title: $product->title,
            image: $product->main_image,
            link: $product->link,
        )),
    ])->render();

    return Mjml::new()->toHtml($content);
});
