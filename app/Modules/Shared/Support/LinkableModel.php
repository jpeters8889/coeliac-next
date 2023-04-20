<?php

declare(strict_types=1);

namespace App\Modules\Shared\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 *
 * @property mixed $link
 * @property mixed $absolute_link
 */
trait LinkableModel
{
    public function initializeLinkable(): void
    {
        $this->append('link');
    }

    public function getLinkAttribute(): string
    {
        return '/' . $this->linkRoot() . '/' . $this->linkColumn();
    }

    public function getAbsoluteLinkAttribute(): string
    {
        return config('app.url') . $this->link;
    }

    protected function linkRoot(): string
    {
        return Str::of(class_basename($this))->lower()->singular()->toString();
    }

    protected function linkColumn(): string
    {
        return $this->slug;
    }
}
