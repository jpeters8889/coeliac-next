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

        return $eatery->county->county === 'Nationwide';
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'name' => ['nullable', 'required_with:email,review', 'string'],
            'email' => ['nullable', 'required_with:name,review', 'email'],
            'review' => ['nullable', 'required_with:name,email', 'string'],
            'food_rating' => ['nullable', 'in:poor,good,excellent'],
            'service_rating' => ['nullable', 'in:poor,good,excellent'],
            'how_expensive' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'images' => ['array', 'max:6'],
            'images.*' => ['string', 'exists:temporary_file_uploads,id'],
            'method' => ['in:website,app'],
            //'admin_review' => $this->user()?->isAdmin() ? ['boolean'] : ['sometimes', 'declined'],
            'branch_name' => $this->isNationwide() ? ['required_with:name,email,review', 'string'] : ['prohibited'],
        ];
    }

    public function shouldReviewBeApproved(): bool
    {
        //        if ($this->boolean('admin_review') === true && $this->user()?->isAdmin()) {
        if ($this->boolean('admin_review')) {
            return true;
        }

        $requiredFieldsCheck = $this->input('name') === null
            && $this->input('email') === null
            && $this->input('review') === null;

        if ($this->isNationwide()) {
            return $this->input('branch_name') !== null && $requiredFieldsCheck;
        }

        return $requiredFieldsCheck;
    }
}
