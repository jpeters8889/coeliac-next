<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\TravelCards;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use App\Http\Response\Inertia;
use App\Models\Shop\ShopFeedback;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;

class IndexController
{
    public function __invoke(Inertia $inertia, GetOpenGraphImageForRouteAction $getOpenGraphImageForRouteAction): Response
    {
        $feedback = ShopFeedback::query()
            ->whereHas(
                'product',
                fn (Builder $query) => $query->whereHas(
                    'categories',
                    fn (Builder $query) => $query->whereIn('slug', ['standard-coeliac-travel-cards', 'coeliac-cards']),
                ),
            )
            ->inRandomOrder()
            ->take(3)
            ->with('product')
            ->get()
            ->map(fn (ShopFeedback $feedback) => [
                'review' => $feedback->feedback,
                'name' => $feedback->name,
                'product' => $feedback->product->title,
                'link' => $feedback->product->link,
            ]);

        return $inertia
            ->title('Gluten Free Travel and Translation Cards')
            ->metaDescription('Travel the world and eat out safely with our fantastic range of gluten free travel and translation cards!')
            ->metaTags([
                'coeliac travel card', 'coeliac translation card', 'gluten free travel card', 'gluten free translation card',
                'allergy card', 'allergy translation card', 'allergy travel card', 'allergen travel card', 'allergen translation card',
            ])
            ->metaImage($getOpenGraphImageForRouteAction->handle('shop'))
            ->render('Shop/TravelCards', [
                'feedback' => $feedback,
            ]);
    }
}
