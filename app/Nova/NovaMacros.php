<?php

declare(strict_types=1);

namespace App\Nova;

use Laravel\Nova\Fields\Field;

class NovaMacros
{
    public static function register(): void
    {
        $self = new static();

        $self->handle();
    }

    protected function handle(): void
    {
        Field::macro('deferrable', function () {
            /** @phpstan-ignore-next-line */
            $this->deferrable = true;

            return $this;
        });
    }
}
