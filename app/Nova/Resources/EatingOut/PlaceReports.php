<?php

declare(strict_types=1);

namespace App\Nova\Resources\EatingOut;

use App\Models\EatingOut\EateryReport;
use App\Nova\Actions\EatingOut\CompleteReportOrRecommendation;
use App\Nova\Resource;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @codeCoverageIgnore
 */
class PlaceReports extends Resource
{
    public static $model = EateryReport::class;

    public static $clickAction = 'preview';

    public static $tableStyle = 'tight';

    public function authorizedToView(Request $request)
    {
        return true;
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->hide(),

            BelongsTo::make('Eatery', resource: Eateries::class)
                ->showOnPreview()
                ->displayUsing(fn (Eateries $eatery) => $eatery->resource->load(['town' => fn (Relation $builder) => $builder->withoutGlobalScopes(), 'county', 'country'])->full_name),

            Text::make('Details')
                ->showOnPreview()
                ->displayUsing(fn (string $details) => Str::wordWrap($details, 100, '<br />'))
                ->asHtml(),

            Boolean::make('Completed')->showOnPreview(),

            DateTime::make('Created', 'created_at')->showOnPreview(),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            CompleteReportOrRecommendation::make()
                ->showInline()
                ->withoutConfirmation()
                ->canRun(fn ($request, EateryReport $report) => $report->completed === false),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes()
//            ->with([
//                'eatery' => fn (Relation $builder) => $builder->withoutGlobalScopes(),
//                'eatery.town' => fn (Relation $builder) => $builder->withoutGlobalScopes(),
//            ])
            ->reorder('completed')->orderByDesc('created_at');
    }
}
