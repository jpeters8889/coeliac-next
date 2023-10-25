<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\DataObjects\EatingOut\GetEateriesPipelineData;
use Closure;
use Tests\TestCase;

/** @mixin TestCase */
trait InteractsWithPipelines
{
    /**
     * @param  class-string  $action
     */
    protected function runPipeline(string $pipeline, ...$props)
    {
        return app($pipeline)->run(...$props);
    }

    /**
     * @param  class-string  $action
     */
    protected function expectPipelineToExecute(string $action): self
    {
        $this
            ->partialMock($action)
            ->shouldReceive('handle')
            ->andReturnUsing(function (GetEateriesPipelineData $data, Closure $next) use ($action) {
                /** @var object{handle: Closure} $action */
                $action = new $action();

                return $action->handle($data, $next);
            })
            ->once();

        return $this;
    }

    /**
     * @param  class-string  $action
     */
    protected function expectPipelineToRun(string $pipeline): self
    {
        $this->partialMock($pipeline)->shouldReceive('run')->once();

        return $this;
    }
}
