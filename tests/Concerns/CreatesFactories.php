<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Database\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as IlluminateFactory;
use Tests\TestCase;

/** @mixin TestCase */
trait CreatesFactories
{
    /**
     * @template T
     *
     * @param  class-string<T>  $what
     * @return IlluminateFactory<T>
     */
    protected function build(string $what): IlluminateFactory
    {
        return Factory::factoryForModel($what);
    }

    /**
     * @template T
     *
     * @param  class-string<T>  $what
     * @return T
     */
    protected function create(string $what, array $attributes = [])
    {
        return $this->build($what)->create($attributes);
    }
}
