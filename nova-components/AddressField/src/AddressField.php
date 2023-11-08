<?php

declare(strict_types=1);

namespace Jpeters8889\AddressField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddressField extends Field
{
    public $component = 'address-field';

    public static $latitude = 'latitude';

    public static $longitude = 'longitude';

    public $showOnIndex = false;

    public $showOnDetail = false;

    public $showOnCreation = true;

    public $showOnUpdate = true;

    public $fullWidth = true;

    public function latitudeField($field): self
    {
        self::$latitude = $field;

        return $this;
    }

    public function longitudeField($field): self
    {
        self::$longitude = $field;

        return $this;
    }

    protected function resolveAttribute($resource, $attribute)
    {
        $address = $resource->$attribute;
        $latitude = $resource->{self::$latitude};
        $longitude = $resource->{self::$longitude};

        return json_encode(compact('address', 'latitude', 'longitude'));
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        $fields = json_decode($request->input($requestAttribute), true);

        $model->$attribute = $fields['address'];
        $model->{self::$latitude} = $fields['latitude'];
        $model->{self::$longitude} = $fields['longitude'];
    }
}
