<?php

declare(strict_types=1);

namespace App\Nova\Support\Actions\Media;

use App\Pipelines\UploadTemporaryFilePipeline;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Jpeters8889\AdvancedNovaMediaLibrary\Contracts\UploadMediaContract;
use Jpeters8889\AdvancedNovaMediaLibrary\DataObjects\UploadedFileResponse;

class Upload implements UploadMediaContract
{
    public function upload(UploadedFile $file): UploadedFileResponse
    {
        $uploadedFile = app(UploadTemporaryFilePipeline::class)->run($file, 'admin', Carbon::now()->addHour());

        return new UploadedFileResponse(
            key: $file->hashName(),
            uuid: $uploadedFile['id'],
            filename: $file->getClientOriginalName(),
            mime_type: $file->getMimeType(),
            file_size: $file->getSize(),
        );
    }
}
