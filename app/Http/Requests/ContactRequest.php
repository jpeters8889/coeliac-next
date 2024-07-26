<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DataObjects\ContactFormData;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ];
    }

    public function toContactDto(): ContactFormData
    {
        return new ContactFormData(
            $this->string('name')->toString(),
            $this->string('email')->toString(),
            $this->string('subject')->toString(),
            $this->string('message')->toString(),
        );
    }
}
