<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Contracts\Comments\HasComments;
use App\Resources\Comments\CommentCollection;

class GetCommentsForItemAction
{
    public function handle(HasComments $item): CommentCollection
    {
        return new CommentCollection(
            $item->comments()
                ->with('reply')
                ->simplePaginate(5, pageName: 'commentPage')
        );
    }
}
