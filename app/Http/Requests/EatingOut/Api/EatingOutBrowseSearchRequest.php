<?php

declare(strict_types=1);

namespace App\Http\Requests\EatingOut\Api;

use Illuminate\Foundation\Http\FormRequest;

class EatingOutBrowseSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'term' => ['required', 'string', 'min:3'],
        ];
    }
}
