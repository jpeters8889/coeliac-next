<?php

declare(strict_types=1);

namespace Tests\Concerns;

use Closure;
use Tests\TestCase;

/** @mixin TestCase */
trait InteractsWithActions
{
    /**
     * @param  class-string  $action
     */
    protected function callAction(string $action, ...$props)
    {
        return app($action)->handle(...$props);
    }

    /**
     * @param  class-string  $action
     */
    protected function expectAction(string $action, ...$args): self
    {
        $mockery = $this->partialMock($action)->shouldReceive('handle');

        if ($args) {
            if (count($args) === 1 && $args[0] instanceof Closure) {
                $args = $args[0];
            }

            $mockery->withArgs($args);
        }

        $mockery->once();

        return $this;
    }
}
