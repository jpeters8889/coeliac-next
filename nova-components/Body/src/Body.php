<?php

declare(strict_types=1);

namespace Jpeters8889\Body;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Body extends Field
{
    public $component = 'body';

    protected $canHaveImages = false;

    public $showOnIndex = false;
    public $showOnDetail = false;
    public $showOnCreation = true;
    public $showOnUpdate = true;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->rows('25');
    }

    public function rows($rows): self
    {
        return $this->withMeta(['rows' => $rows]);
    }

    protected function resolveAttribute($resource, $attribute): mixed
    {
        $rawContents = parent::resolveAttribute($resource, $attribute);

        if ( ! $rawContents) {
            return null;
        }

        if ($this->canHaveImages) {
            /** @var HasMedia $resource */

            $resource->getMedia('body')->each(function (Media $media) use (&$rawContents): void {
                $rawContents = str_replace($media->getUrl(), $media->file_name, $rawContents);
            });
        }

        return $rawContents;
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        $value = $request[$requestAttribute];

        if ($this->canHaveImages()) {
            /** @var HasMedia $model */

            $model->getMedia('body')->each(function (Media $media) use (&$value): void {
                $value = str_replace($media->file_name, $media->getUrl(), $value);
            });
        }

        $value = $value;

        $model->$attribute = $value;
    }

    public function canHaveImages(): self
    {
        $this->canHaveImages = true;

        return $this;
    }
}
