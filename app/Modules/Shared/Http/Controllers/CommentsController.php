<?php

namespace App\Modules\Shared\Http\Controllers;

use App\Modules\Shared\Comments\CommentRequest;

class CommentsController
{
    public function __invoke(CommentRequest $request)
    {
        $item = $request->resolveItem();

        $test = $item->comments()->create($request->comment());

        return redirect()->back();
    }
}
