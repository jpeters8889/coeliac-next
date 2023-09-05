<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\TemporaryFileUploadPipeline;

use App\Actions\TemporaryFileUploadPipeline\StoreInDatabaseAction;
use App\Actions\TemporaryFileUploadPipeline\UploadFileAction;
use App\DataObjects\TemporaryFileUploadPipelineData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

abstract class TemporaryFileUploadTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('uploads');
    }

    protected function callUploadFileAction(UploadedFile $file): ?TemporaryFileUploadPipelineData
    {
        $toReturn = null;

        $closure = function (TemporaryFileUploadPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new TemporaryFileUploadPipelineData(
            file: $file,
        );

        $this->callAction(UploadFileAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callStoreInDatabaseAction(UploadedFile $file): ?TemporaryFileUploadPipelineData
    {
        $toReturn = null;

        $closure = function (TemporaryFileUploadPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = $this->callUploadFileAction($file);

        $this->callAction(StoreInDatabaseAction::class, $pipelineData, $closure);

        return $toReturn;
    }
}
