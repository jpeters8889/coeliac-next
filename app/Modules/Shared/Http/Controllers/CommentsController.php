<?php

declare(strict_types=1);

namespace App\Modules\Shared\Http\Controllers;

use App\Modules\Shared\Comments\CommentRequest;
use Illuminate\Http\RedirectResponse;

class CommentsController
{
    public function __invoke(CommentRequest $request): RedirectResponse
    {
        $item = $request->resolveItem();

        $item->comments()->create($request->comment());

        return redirect()->back();
    }
}
