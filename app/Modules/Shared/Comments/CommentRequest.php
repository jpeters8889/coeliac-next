<?php

namespace App\Modules\Shared\Comments;

use App\Modules\Blog\Models\Blog;
use App\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function resolveItem(): Blog | Recipe
    {
        $builder = match ($this->string('module')->toString()) {
            'blog' => Blog::query(),
            'recipe' => Recipe::query(),
            default => throw new NotFoundHttpException(),
        };

       return $builder->findOrFail($this->integer('id'));
    }

    public function rules(): array
    {
        return [
            'module' => ['required', Rule::in(['blog', 'recipe'])],
            'id' => ['required', 'numeric', 'bail', function(string $attribute, mixed $value, \Closure $fail) {
                $builder = match ($this->input('module')) {
                    'blog' => Blog::query(),
                    'recipe' => Recipe::query(),
                };

                $check = $builder->where('id', $value)->exists();

                if (!$check) {
                    $fail("The {$this->input('module')} can not be found.");
                }
            }],
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'comment' => ['required'],
        ];
    }

    public function comment(): array
    {
        return $this->only(['name', 'email', 'comment']);
    }
}
