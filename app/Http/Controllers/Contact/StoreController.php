<?php

declare(strict_types=1);

namespace App\Http\Controllers\Contact;

use App\Events\ContactFormSubmittedEvent;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;

class StoreController
{
    public function __invoke(ContactRequest $request): RedirectResponse
    {
        ContactFormSubmittedEvent::dispatch($request->toContactDto());

        return redirect()->back();
    }
}
