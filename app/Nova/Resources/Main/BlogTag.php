<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main;

use App\Modules\Blog\Models\BlogTag as BlogTagModel;
use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<BlogTagModel> */
class BlogTag extends Resource
{
    public static $displayInNavigation = false;

    public static string $model = BlogTagModel::class;

    public static $title = 'tag';

    public static $search = ['tag'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id'),

            Text::make('Tag'),
        ];
    }
}
