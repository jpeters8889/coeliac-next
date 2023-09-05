<?php

declare(strict_types=1);

namespace App\Pipelines;

use App\Actions\TemporaryFileUploadPipeline\MapToResponseAction;
use App\Actions\TemporaryFileUploadPipeline\StoreInDatabaseAction;
use App\Actions\TemporaryFileUploadPipeline\UploadFileAction;
use App\DataObjects\TemporaryFileUploadPipelineData;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Pipeline\Pipeline;

class UploadTemporaryFilePipeline
{
    public function run(UploadedFile $file, string $source = 'upload', Carbon $deleteAt = null): array
    {
        $pipes = [
            UploadFileAction::class,
            StoreInDatabaseAction::class,
            MapToResponseAction::class,
        ];

        $pipelineData = new TemporaryFileUploadPipelineData(
            file: $file,
            source: $source,
            deleteAt: $deleteAt ?? Carbon::now()->addDay(),
        );

        /** @var TemporaryFileUploadPipelineData $pipeline */
        $pipeline = app(Pipeline::class)
            ->send($pipelineData)
            ->through($pipes)
            ->thenReturn();

        /** @var array $returnData */
        $returnData = $pipeline->returnData;

        return $returnData;
    }
}
