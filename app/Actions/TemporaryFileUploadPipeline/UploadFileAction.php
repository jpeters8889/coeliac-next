<?php

declare(strict_types=1);

namespace App\Actions\TemporaryFileUploadPipeline;

use App\Contracts\TemporaryFileUploadPipelineActionContract;
use App\DataObjects\TemporaryFileUploadPipelineData;
use Closure;

class UploadFileAction implements TemporaryFileUploadPipelineActionContract
{
    public function handle(TemporaryFileUploadPipelineData $pipelineData, Closure $next): mixed
    {
        $pipelineData->path = (string) $pipelineData->file->store('/', 'uploads');

        return $next($pipelineData);
    }
}
