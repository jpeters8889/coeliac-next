<?php

declare(strict_types=1);

namespace App\Mail;

use App\DataObjects\ContactFormData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(protected ContactFormData $contactFormData)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Contact Form - {$this->contactFormData->subject}",
            replyTo: [
                $this->contactFormData->name => $this->contactFormData->email,
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form',
            with: [
                'data' => $this->contactFormData,
            ]
        );
    }
}
