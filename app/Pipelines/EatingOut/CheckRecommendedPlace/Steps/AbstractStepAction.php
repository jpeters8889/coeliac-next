<?php

declare(strict_types=1);

namespace App\Pipelines\EatingOut\CheckRecommendedPlace\Steps;

use App\DataObjects\EatingOut\RecommendAPlaceExistsCheckData;
use Closure;

abstract class AbstractStepAction
{
    public function handle(RecommendAPlaceExistsCheckData $data, Closure $next): mixed
    {
        if ( ! $data->found && mb_strlen($data->name ?? '') >= 5) {
            $this->check($data);
        }

        return $next($data);
    }

    abstract protected function check(RecommendAPlaceExistsCheckData $data): void;
}
