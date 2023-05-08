<?php

declare(strict_types=1);

namespace App\Nova\Support\Panels;

use Carbon\Carbon;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class VisibilityPanel
{
    public static function make(): Panel
    {
        return new Panel('Visibility', [
            Boolean::make('Draft', 'draft')->filterable()
                ->onlyOnForms()
                ->dependsOn('live', function (Boolean $field, NovaRequest $request, FormData $formData): void {
                    /** @phpstan-ignore-next-line */
                    if ($formData->live === true) {
                        $field->hide();
                    }
                })
                ->rules(['required_without_all:live,publish_at', 'prohibited_if:live:publish_at']),

            Boolean::make('Published', 'live')
                ->dependsOn('draft', function (Boolean $field, NovaRequest $request, FormData $formData): void {
                    /** @phpstan-ignore-next-line */
                    if ($formData->draft === true) {
                        $field->hide();
                    }
                })
                ->filterable()
                ->rules(['required_without_all:draft,publish_at', 'prohibited_if:draft,publish_at']),

            DateTime::make('Or Publish At', 'publish_at')
                ->onlyOnForms()
                ->hide()
                ->default(fn () => Carbon::now()->addHour()->startOfHour())
                ->dependsOn(['live', 'draft'], function (DateTime $field, NovaRequest $request, FormData $formData): void {
                    /** @phpstan-ignore-next-line */
                    if ($formData->live === false && $formData->draft === false) {
                        $field->show();
                    }
                })
                ->rules(['required_without_all:live,draft', 'prohibited_if:live,draft']),
        ]);
    }
}
