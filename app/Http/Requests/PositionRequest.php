<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PositionRequest extends FormRequest
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
    public function rules(): array {
        return $this->isMethod('post') ? $this->create_position() : $this->update_positions();
    }

    public function create_position()
    {
        return [
            'title' => ['required', 'unique:positions,title'],
            'level' => ['required', Rule::in(config('hr.levels'))],
            'department_id' => ['required', 'exists:departments,id'],
            'description' => ['nullable', 'string', 'max:255']
        ];
    }
    public function update_positions()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'level' => ['required', Rule::in(config('hr.levels'))],
            'department_id' => ['required', 'exists:departments,id'],
            'description' => ['nullable', 'string', 'max:255']
        ];
    }
}
