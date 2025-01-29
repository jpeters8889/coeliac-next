<?php

declare(strict_types=1);

namespace App\Actions\OpenGraphImages;

use App\Contracts\HasOpenGraphImageContract;
use App\Jobs\OpenGraphImages\CreateEatingOutOpenGraphImageJob;

class GetEatingOutOpenGraphImageAction
{
    public function handle(HasOpenGraphImageContract $model): string
    {
        if ( ! $model->relationLoaded('openGraphImage')) {
            $model->load('openGraphImage');
        }

        /** @phpstan-ignore-next-line  */
        if ($model->openGraphImage?->image_url) {
            return $model->openGraphImage->image_url;
        }

        CreateEatingOutOpenGraphImageJob::dispatch($model);

        return '';
    }
}
