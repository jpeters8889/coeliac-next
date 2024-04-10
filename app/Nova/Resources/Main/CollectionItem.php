<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main;

use App\Models\Collections\CollectionItem as CollectionItemModel;
use App\Nova\Resource;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use PixelCreation\NovaFieldSortable\Concerns\SortsIndexEntries;
use PixelCreation\NovaFieldSortable\Sortable;

/** @extends Resource<CollectionItemModel> */
/**
 * @codeCoverageIgnore
 */
class CollectionItem extends Resource
{
    use SortsIndexEntries;

    public static string $defaultSortField = 'position';

    public static string $model = CollectionItemModel::class;

    public static $perPageViaRelationship = 20;

    public function fields(NovaRequest $request)
    {
        return [
            MorphTo::make('Item')->types([
                Blog::class,
                Recipe::class,
            ]),

            Sortable::make('Position')->onlyOnIndex(),
        ];
    }
}
