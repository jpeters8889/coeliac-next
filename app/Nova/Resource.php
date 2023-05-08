<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

/**
 * @template TModel of Model
 *
 * @mixin TModel
 *
 * @method mixed getKey()
 *
 * @extends NovaResource<TModel>
 */
abstract class Resource extends NovaResource
{
    /** @var Collection<int, Field>  */
    protected static Collection $deferrableFields;

    public static $clickAction = 'edit';

    /** @param Resource<TModel> $resource */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/' . static::uriKey();
    }

    /** @param Resource<TModel> $resource */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/' . static::uriKey();
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }

    public static function fill(NovaRequest $request, $model)
    {
        self::$deferrableFields = new Collection();

        $model::saved(function ($model) use ($request): void {
            self::$deferrableFields->each(function (Field $field) use ($model, $request): void {
                $field->fillInto($request, $model, $field->attribute);
            });
        });

        return parent::fill($request, $model);
    }

    public static function fillForUpdate(NovaRequest $request, $model)
    {
        self::$deferrableFields = new Collection();

        $model::saved(function ($model) use ($request): void {
            self::$deferrableFields->each(function (Field $field) use ($model, $request): void {
                $field->fillInto($request, $model, $field->attribute);
            });
        });

        return parent::fill($request, $model);
    }

    protected static function fillFields(NovaRequest $request, $model, $fields)
    {
        /** @phpstan-ignore-next-line  */
        self::$deferrableFields = $fields->filter(fn ($field) => property_exists($field, 'deferrable') && $field->deferrable);

        $fields = $fields->reject(fn ($field) => property_exists($field, 'deferrable') && $field->deferrable);

        return parent::fillFields($request, $model, $fields);
    }
}
