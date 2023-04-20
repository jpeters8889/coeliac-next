<?php

declare(strict_types=1);

namespace App\Modules\Shared\Models;

use App\Modules\Shared\Support\DisplaysDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property string $commentable_type
 * @property Comment | null $reply
 * @property string $published
 */
class Comment extends Model
{
    use DisplaysDates;

    protected $appends = ['what'];

    protected $attributes = [
        'approved' => false,
    ];

    protected $casts = [
        'approved' => 'bool'
    ];

    public function reply(): HasOne
    {
        return $this->hasOne(CommentReply::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getWhatAttribute(): string
    {
        return class_basename($this->commentable_type);
    }
}
