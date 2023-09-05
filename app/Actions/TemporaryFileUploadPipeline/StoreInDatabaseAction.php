<?php

declare(strict_types=1);

namespace App\Actions\TemporaryFileUploadPipeline;

use App\Contracts\TemporaryFileUploadPipelineActionContract;
use App\DataObjects\TemporaryFileUploadPipelineData;
use App\Models\TemporaryFileUpload;
use Carbon\Carbon;
use Closure;

class StoreInDatabaseAction implements TemporaryFileUploadPipelineActionContract
{
    public function handle(TemporaryFileUploadPipelineData $pipelineData, Closure $next): mixed
    {
        $pipelineData->model = TemporaryFileUpload::query()->create([
            'filename' => $pipelineData->file->hashName(),
            'path' => $pipelineData->path,
            'source' => $pipelineData->source,
            'filesize' => $pipelineData->file->getSize(),
            'mime' => $pipelineData->file->getMimeType(),
            'delete_at' => $pipelineData->deleteAt ?? Carbon::now()->addDay(),
        ]);

        return $next($pipelineData);
    }
}
