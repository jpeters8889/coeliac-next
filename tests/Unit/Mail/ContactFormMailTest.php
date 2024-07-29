<?php

declare(strict_types=1);

namespace Tests\Unit\Mail;

use App\DataObjects\ContactFormData;
use App\Mail\ContactFormMail;
use Illuminate\Mail\Mailables\Address;
use Tests\TestCase;

class ContactFormMailTest extends TestCase
{
    /** @test */
    public function itHasTheSubjectSet(): void
    {
        $emailData = new ContactFormData('name', 'email', 'This is the subject', 'message');

        $mailable = new ContactFormMail($emailData);

        $this->assertEquals('New Contact Form - This is the subject', $mailable->envelope()->subject);
    }

    /** @test */
    public function itHasTheReplyToDetails(): void
    {
        $emailData = new ContactFormData('name', 'email', 'This is the subject', 'message');

        $mailable = new ContactFormMail($emailData);

        $this->assertEquals([new Address('email', 'name')], $mailable->envelope()->replyTo);
    }

    /** @test */
    public function itHasTheCorrectView(): void
    {
        $emailData = new ContactFormData('name', 'email', 'This is the subject', 'message');

        $mailable = new ContactFormMail($emailData);

        $this->assertEquals('emails.contact-form', $mailable->content()->view);
    }

    /** @test */
    public function itHasTheCorrectData(): void
    {
        $emailData = new ContactFormData('name', 'email', 'This is the subject', 'message');

        $mailable = new ContactFormMail($emailData);

        $this->assertEquals(['data' => $emailData], $mailable->content()->with);
    }
}
