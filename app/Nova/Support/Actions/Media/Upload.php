<?php

declare(strict_types=1);

namespace App\Nova\Support\Actions\Media;

use App\Modules\Shared\Models\TemporaryFileUpload;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Jpeters8889\AdvancedNovaMediaLibrary\Contracts\UploadMediaContract;
use Jpeters8889\AdvancedNovaMediaLibrary\DataObjects\UploadedFileResponse;

class Upload implements UploadMediaContract
{
    public function upload(UploadedFile $file): UploadedFileResponse
    {
        $uploadedFile = TemporaryFileUpload::createFrom(
            $file,
            (string) $file->store('/', 'uploads'),
            'admin',
            Carbon::now()->addHour()
        );

        return new UploadedFileResponse(
            key: $file->hashName(),
            uuid: $uploadedFile->id,
            filename: $file->getClientOriginalName(),
            mime_type: $file->getMimeType(),
            file_size: $file->getSize(),
        );
    }
}
