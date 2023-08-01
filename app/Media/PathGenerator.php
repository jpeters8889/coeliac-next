<?php

declare(strict_types=1);

namespace App\Media;

use App\Models\Media;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class PathGenerator extends DefaultPathGenerator
{
    protected function getBasePath(Model $media): string
    {
        /** @var Media $media */

        $basename = Str::of(class_basename($media->model_type))->lower()->plural()->toString();

        $identifier = $media->getCustomProperty('slug', $media->model_id);

        return implode('/', [$basename, $identifier]);
    }
}
