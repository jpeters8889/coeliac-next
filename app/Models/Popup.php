<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\DisplaysMedia;
use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Popup extends Model implements HasMedia
{
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;
    use InteractsWithMedia;

    protected static function booted(): void
    {
        static::addGlobalScope(new LiveScope());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary')->singleFile();
    }
}
