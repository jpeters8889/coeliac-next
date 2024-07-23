<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class TravelCardSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'term' => ['required', 'string'],
        ];
    }
}
