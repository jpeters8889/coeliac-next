<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\ContactFormData;
use App\Events\ContactFormSubmittedEvent;
use App\Listeners\SendContactFormListener;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendContactFormListenerTest extends TestCase
{
    #[Test]
    public function itEmailsTheContactFormToTheMainEmailAddress(): void
    {
        Mail::fake();

        $event = new ContactFormSubmittedEvent(new ContactFormData('foo', 'bar', 'baz', '123'));

        app(SendContactFormListener::class)->handle($event);

        Mail::assertQueued(ContactFormMail::class, fn (ContactFormMail $mail) => $mail->hasTo('contact@coeliacsanctuary.co.uk'));
    }
}
