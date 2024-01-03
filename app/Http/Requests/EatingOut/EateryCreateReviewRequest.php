<?php

declare(strict_types=1);

namespace App\Http\Requests\EatingOut;

use App\Models\EatingOut\Eatery;
use Illuminate\Foundation\Http\FormRequest;

class EateryCreateReviewRequest extends FormRequest
{
    protected function isNationwide(): bool
    {
        /** @var Eatery $eatery */
        $eatery = $this->route('eatery');

        return $eatery->county?->county === 'Nationwide';
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'name' => ['nullable', 'required', 'string'],
            'email' => ['nullable', 'required', 'email'],
            'review' => ['nullable', 'required', 'string'],
            'food_rating' => ['nullable', 'in:poor,good,excellent'],
            'service_rating' => ['nullable', 'in:poor,good,excellent'],
            'how_expensive' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'images' => ['array', 'max:6'],
            'images.*' => ['string', 'exists:temporary_file_uploads,id'],
            'method' => ['in:website,app'],
            //'admin_review' => $this->user()?->isAdmin() ? ['boolean'] : ['sometimes', 'declined'],
            'branch_name' => $this->isNationwide() ? ['nullable', 'required', 'string'] : ['prohibited'],
        ];
    }

    public function shouldReviewBeApproved(): bool
    {
        //        if ($this->boolean('admin_review') === true && $this->user()?->isAdmin()) {
        if ($this->boolean('admin_review')) {
            return true;
        }

        return true;
    }
}
