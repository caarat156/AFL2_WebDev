<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // pastikan route memakai 'auth'
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower($this->input('email')), // aman
            ]);
        }
    }

    public function rules(): array
    {
        $userId = auth()->check() ? auth()->id() : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $userId 
                    ? Rule::unique(User::class)->ignore($userId) 
                    : Rule::unique(User::class)
            ],
        ];
    }
}
