<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Support\Arr;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    public static function resolveFactoryName(string $modelName)
    {
        $modelName = Arr::last(explode('\\', $modelName));

        return static::$namespace . $modelName . 'Factory';
    }
}
