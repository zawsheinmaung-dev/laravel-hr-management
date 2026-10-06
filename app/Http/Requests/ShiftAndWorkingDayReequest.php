<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftAndWorkingDayReequest extends FormRequest
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
            'name'=>['required','string','max:255'],
            'start_time'=>['required'],
            'end_time'=>['required'],
            'grace_minutes'=>['required'],
            'break_minutes'=>['required'],
            'working_days'=>['required','array','min:1'],
            'working_days.*'=>[Rule::in(config('workingdays.days'))]
        ];
    }
}
