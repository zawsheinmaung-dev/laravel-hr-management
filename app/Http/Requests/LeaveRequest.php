<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveRequest extends FormRequest
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
        return $this->isMethod('POST')
            ? $this->createRules()
            : $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'leavetype_id' => ['required', 'exists:leavetypes,id'],
            'reason' => ['required', 'string'],
        ];
    }

    private function updateRules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(config('status.leave.statuses')),
            ],
        ];
    }
}
