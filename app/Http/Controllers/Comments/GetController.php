<?php

declare(strict_types=1);

namespace App\Http\Controllers\Comments;

use App\Http\Requests\Comments\CommentRequest;
use Illuminate\Http\RedirectResponse;

class GetController
{
    public function __invoke(CommentRequest $request): RedirectResponse
    {
        $item = $request->resolveItem();

        $item->comments()->create($request->comment());

        return redirect()->back();
    }
}
