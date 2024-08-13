<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Jobs\CreateOpenGraphImageJob;

class GetOpenGraphImageAction
{
    public function handle(HasOpenGraphImageContract $model): string
    {
        if ( ! $model->relationLoaded('openGraphImage')) {
            $model->load('openGraphImage');
        }

        /** @phpstan-ignore-next-line  */
        if ($model->openGraphImage?->imageUrl()) {
            return $model->openGraphImage->image_url;
        }

        CreateOpenGraphImageJob::dispatch($model);

        return '';
    }
}
