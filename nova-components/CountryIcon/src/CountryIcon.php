<?php

declare(strict_types=1);

namespace Jpeters8889\CountryIcon;

use Laravel\Nova\Fields\Field;

class CountryIcon extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'country-icon';

    public function withLabel(): static
    {
        return $this->withMeta(['label' => true]);
    }
}
