<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Models\TemporaryFileUpload;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class TemporaryFileUploadPipelineData
{
    public function __construct(
        public UploadedFile $file,
        public string $source = 'upload',
        public ?Carbon $deleteAt = null,
        public ?string $path = null,
        public ?TemporaryFileUpload $model = null,
        public ?array $returnData = null,
    ) {
    }
}
