<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\OpenGraphImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @phpstan-property  OpenGraphImage $openGraphImage
 *
 * @mixin Model
 */
interface HasOpenGraphImageContract
{
    /** @return MorphOne<OpenGraphImage> */
    public function openGraphImage(): MorphOne;
}
