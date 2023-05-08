<?php

declare(strict_types=1);

namespace App\Nova\Support\Actions\Media;

use App\Modules\Shared\Models\TemporaryFileUpload;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Jpeters8889\AdvancedNovaMediaLibrary\Contracts\GetUploadedMediaContract;

class Get implements GetUploadedMediaContract
{
    public function resolveFromUuid(string $uuid): string
    {
        /** @var TemporaryFileUpload $image */
        $image = TemporaryFileUpload::query()->find($uuid);

        return Storage::disk('uploads')->temporaryUrl($image->path, Carbon::now()->addHour());
    }
}
