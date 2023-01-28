<?php

declare(strict_types=1);

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogTag extends Model
{
    /** @return BelongsToMany<Blog> */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_assigned_tags', 'tag_id', 'blog_id');
    }
}
