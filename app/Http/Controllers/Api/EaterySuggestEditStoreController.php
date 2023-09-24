<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\EatingOut\StoreSuggestedEditAction;
use App\Http\Requests\EatingOut\SuggestEditRequest;
use App\Models\EatingOut\Eatery;

class EaterySuggestEditStoreController
{
    public function __invoke(Eatery $eatery, SuggestEditRequest $request, StoreSuggestedEditAction $storeSuggestedEditAction): void
    {
        $storeSuggestedEditAction->handle(
            $eatery,
            $request->string('field')->toString(),
            $request->input('value'),
        );
    }
}
