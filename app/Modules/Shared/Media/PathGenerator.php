<?php

declare(strict_types=1);

namespace App\Modules\Shared\Media;

use App\Modules\Shared\Models\Media;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

class PathGenerator extends DefaultPathGenerator
{
    protected function getBasePath(Model $media): string
    {
        /** @var Media $media */

        $basename = Str::of(class_basename($media->model))->lower()->plural()->toString();

        $identifier = $media->getCustomProperty('slug', $media->model_id);

        return implode('/', [$basename, $identifier]);
    }
}
