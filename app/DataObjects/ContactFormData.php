<?php

declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Support\Str;

readonly class ContactFormData
{
    public function __construct(public string $name, public string $email, public string $subject, public string $message)
    {
        //
    }

    public function renderedMessage(): string
    {
        return Str::markdown($this->message, [
            'renderer' => [
                'soft_break' => '<br />',
            ],
        ]);
    }
}
