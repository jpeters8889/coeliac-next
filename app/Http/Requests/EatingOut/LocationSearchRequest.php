<?php

declare(strict_types=1);

namespace App\Http\Requests\EatingOut;

use Illuminate\Foundation\Http\FormRequest;

class LocationSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'term' => ['required', 'string', 'min:3'],
        ];
    }
}
