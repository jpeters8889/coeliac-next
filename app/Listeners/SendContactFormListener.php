<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContactFormSubmittedEvent;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class SendContactFormListener
{
    public function handle(ContactFormSubmittedEvent $event): void
    {
        Mail::to('contact@coeliacsanctuary.co.uk')->send(new ContactFormMail($event->contactFormData));
    }
}
