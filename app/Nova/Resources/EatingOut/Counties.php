<?php

declare(strict_types=1);

namespace App\Nova\Resources\EatingOut;

use App\Models\Collections\Collection as CollectionModel;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Jpeters8889\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<EateryCounty> */
class Counties extends Resource
{
    public static $group = 'Eating Out';

    /** @var class-string<EateryCounty> */
    public static string $model = EateryCounty::class;

    public static $title = 'county';

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('id')->hide(),

            Text::make('Name', 'county')->fullWidth()->rules(['required', 'max:200'])->sortable(),

            Slug::make('Slug')->from('Name')
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnCreating()
                ->fullWidth()
                ->rules(['required', 'max:200', 'unique:wheretoeat_counties,slug']),

            Select::make('Country', 'country_id')
                ->displayUsingLabels()
                ->filterable()
                ->fullWidth()
                ->options(
                    EateryCountry::query()
                        ->get()
                        ->mapWithKeys(fn (EateryCountry $country) => [$country->id => $country->country])
                ),

            Images::make('Image', 'primary')
                ->onlyOnForms()
                ->addButtonLabel('Select Image')
                ->nullable(),

            Boolean::make('Live', fn () => $this->eateries_count > 0)->onlyOnIndex(),

            Number::make('Towns', 'active_towns_count')->onlyOnIndex()->sortable(),

            Number::make('Eateries', 'eateries_count')->onlyOnIndex()->sortable(),
        ];
    }

    /**
     * @param Builder<CollectionModel> $query
     * @return Builder<CollectionModel | Model>
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->withCount(['activeTowns', 'eateries' => fn (Builder $relation) => $relation->where('live', true)])
            ->when($request->missing('orderByDirection'), fn (Builder $builder) => $builder->reorder('county')); /** @phpstan-ignore-line */
    }
}
