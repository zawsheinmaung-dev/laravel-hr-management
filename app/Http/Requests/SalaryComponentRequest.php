<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalaryComponentRequest extends FormRequest
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
        return $this->isMethod('post') ? $this->store() :$this->update();
    }

    public function store()
    {
        return [
            'name'=>['required','string','max:255'],
            'type'=>['required','in:earning,deduction'],
            'description'=>['nullable','string','max:255'],
            'structure_name'=>['required','string','max:255'],
            'structure_description'=>['required','string','max:255'],
            'selected_items'=>['required','array','min:1'],
            'selected_items.* .calculation_type'=>['required','in:fixed,percentage'],
            'selected_items.* .amount'=>['nullable','numeric','min:0'],
            'selected_items.* .percentage'=>['nullable','numeric','min:0'],
            'selected_items.* .effective_date'=>['required','date'],
        ];
    }

    public function update()
    {
        return [
            'name'=>['required','string','max:255'],
            'type'=>['required','in:earning,deduction'],
            'description'=>['nullable','string','max:255'],
            'structure_id'=>['required','exists:salary_structures,id'],
            'structure_name'=>['required','string','max:255'],
            'structure_description'=>['required','string','max:255'],
            'selected_items'=>['required','array','min:1'],
            'selected_items.* .calculation_type'=>['required','in:fixed,percentage'],
            'selected_items.* .amount'=>['nullable','numeric','min:0'],
            'selected_items.* .percentage'=>['nullable','numeric','min:0'],
            'selected_items.* .effective_date'=>['required','date'],
        ];
    }
}
