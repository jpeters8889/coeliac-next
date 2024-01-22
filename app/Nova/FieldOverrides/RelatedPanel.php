<?php

declare(strict_types=1);

namespace App\Nova\FieldOverrides;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Panel;

class RelatedPanel extends Panel
{
    protected function prepareFields($fields)
    {
        $fields = parent::prepareFields($fields);

        return collect($fields)
            ->each(function (Field $field): void {
                $field->deferrable()
                    ->hide()
                    ->showOnCreating()
                    ->fillUsing(function (...$args): void {
                        // need to somehow get and know the relationship, pass it to the fill using and build up the related
                        dd($args);
                    });
            })
            ->all();
    }
}
