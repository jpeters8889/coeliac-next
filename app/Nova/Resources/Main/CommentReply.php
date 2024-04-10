<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main;

use App\Models\Recipes\RecipeAllergen;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<RecipeAllergen> */
/**
 * @codeCoverageIgnore
 */
class CommentReply extends Resource
{
    public static string $model = \App\Models\Comments\CommentReply::class;

    public static $clickAction = 'view';

    public function authorizedToView(Request $request)
    {
        return true;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->hidden(),

            BelongsTo::make('Comment', resource: Comments::class),

            Textarea::make('Comment', 'comment_reply')->alwaysShow(),

            DateTime::make('Added', 'created_at'),
        ];
    }
}
