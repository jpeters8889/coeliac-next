<?php

declare(strict_types=1);

namespace App\Events;

use App\DataObjects\ContactFormData;
use Illuminate\Foundation\Events\Dispatchable;

class ContactFormSubmittedEvent
{
    use Dispatchable;

    public function __construct(public ContactFormData $contactFormData)
    {
    }
}
