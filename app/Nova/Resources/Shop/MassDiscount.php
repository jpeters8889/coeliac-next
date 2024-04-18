<?php

declare(strict_types=1);

namespace App\Nova\Resources\Shop;

use App\Models\Shop\ShopMassDiscount;
use App\Nova\Resource;
use App\Nova\Resources\Main\PolymorphicPanels\ShopCategories as ShopCategoriesPanel;
use Illuminate\Http\Request;
use Jpeters8889\PolymorphicPanel\PolymorphicPanel;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

/** @extends Resource<ShopMassDiscount> */
/**
 * @codeCoverageIgnore
 */
class MassDiscount extends Resource
{
    /** @var class-string<ShopMassDiscount> */
    public static string $model = ShopMassDiscount::class;

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Title')->rules('required'),

            Number::make('Percentage')->min(1)->max(100)->rules('required'),

            DateTime::make('Start At')
                ->min(now())
                ->default(now()->addDay())
                ->rules('required'),

            DateTime::make('End At')
                ->dependsOn('start_at', function (DateTime $field, NovaRequest $request, FormData $formData): void {
                    $startAt = $request->date('start_at');

                    $field
                        ->min($startAt)
                        ->default(fn () => $startAt->addWeek()->endOfDay());
                }),

            new Panel('Assigned Categories', [
                PolymorphicPanel::make('Assigned Categories', new ShopCategoriesPanel())->display('row'),
            ]),
        ];
    }

    public function authorizedToUpdate(Request $request)
    {
        return now()->lessThan($this->start_at);
    }
}
