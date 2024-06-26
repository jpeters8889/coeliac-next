<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewItem;
use App\Nova\FieldOverrides\Stack;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @extends Resource<ShopOrderReview>
 *
 * @codeCoverageIgnore
 */
class OrderReviews extends Resource
{
    /** @var class-string<ShopOrderReview> */
    public static string $model = ShopOrderReview::class;

    public static $clickAction = 'view';

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Name'),

            Stack::make('Reviewed Products', [
                fn (ShopOrderReview $resource) => $resource
                    ->products()
                    ->with('product')
                    ->get()
                    ->map(fn (ShopOrderReviewItem $item) => "{$item->product->title} ({$item->rating} stars)"),
            ])->onlyOnIndex(),

            Date::make('Created At')->exceptOnForms(),

            HasMany::make('Reviewed Items', 'products', OrderReviewItem::class),
        ];
    }

    public function authorizedToView(Request $request): bool
    {
        return true;
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }
}
