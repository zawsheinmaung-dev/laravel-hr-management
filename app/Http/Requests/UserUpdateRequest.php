<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),

            ],

            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',

            ],

            'roles' => 'required|array|min:1',
            'roles*' => 'exists:roles,name'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain uppercase, lowercase, number and special character.',

            'roles.array' => 'Invalid roles format.',
            'roles.min' => 'Please select at least one role.',
            'roles.*.exists' => 'Selected role is invalid.',
        ];
    }
}
