<?php

declare(strict_types=1);

use App\Nova\Support\Actions\Media\Get as GetMediaAction;
use App\Nova\Support\Actions\Media\Upload as UploadMediaAction;

return [
    'downloadable' => false,
    'default-croppable' => false,
    'enable-existing-media' => false,
    'hide-media-collections' => [],
    'upload-images-using' => UploadMediaAction::class,
    'get-uploaded-media-using' => GetMediaAction::class,
];
