<?php

declare(strict_types=1);

namespace App\Nova\Resources\EatingOut;

use App\Models\EatingOut\EateryReview;
use App\Nova\Actions\EatingOut\ApproveReview;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Reviews extends Resource
{
    public static $model = EateryReview::class;

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $clickAction = 'preview';

    public function authorizedToView(Request $request)
    {
        return true;
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->hide(),

            BelongsTo::make('eatery', resource: Eateries::class)
                ->displayUsing(fn (Eateries $eatery) => $eatery->resource->load(['town', 'county', 'country'])->full_name)
                ->exceptOnForms(),

            new Panel('User', [
                Text::make('Name')->showOnPreview(),

                Email::make('Email')->hideFromIndex()->showOnPreview(),

                Text::make('Ip')->withMeta(['disabled' => true])->hideFromIndex(),

                Text::make('Method')->withMeta(['disabled' => true]),
            ]),

            new Panel('Ratings', [
                Number::make('Rating')
                    ->required()
                    ->min(1)
                    ->max(5)
                    ->showOnPreview(),

                Number::make('How Expensive')
                    ->min(1)
                    ->max(5)
                    ->showOnPreview(),

                Select::make('Food Rating')->displayUsingLabels()->options([
                    'poor' => 'Poor',
                    'ok' => 'Ok',
                    'excellent' => 'Excellent',
                ])->showOnPreview(),

                Select::make('Service Rating')->displayUsingLabels()->options([
                    'poor' => 'Poor',
                    'ok' => 'Ok',
                    'excellent' => 'Excellent',
                ])->showOnPreview(),
            ]),

            new Panel('Review', [
                Text::make('Branch Name')->hideFromIndex()->showOnPreview(),

                Textarea::make('Review')->showOnPreview(),

                Boolean::make('Approved')->showOnPreview(),
            ]),

            //            HasMany::make('Images', 'images', EateryReviewImage::class),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            ApproveReview::make()->showInline()->canRun(fn ($request, EateryReview $review) => $review->approved === false),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes();
    }
}
