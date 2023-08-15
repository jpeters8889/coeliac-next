<?php

declare(strict_types=1);

namespace App\Contracts\EatingOut;

use App\DataObjects\EatingOut\GetEateriesPipelineData;
use Closure;

interface GetEateriesPipelineActionContract
{
    public function handle(GetEateriesPipelineData $pipelineData, Closure $next): mixed;
}
