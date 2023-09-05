<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataObjects\TemporaryFileUploadPipelineData;
use Closure;

interface TemporaryFileUploadPipelineActionContract
{
    public function handle(TemporaryFileUploadPipelineData $pipelineData, Closure $next): mixed;
}
