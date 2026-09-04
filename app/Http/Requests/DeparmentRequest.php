<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeparmentRequest extends FormRequest
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
        $id =$this->route('deparment');
        return $this->isMethod('POST') ? $this->deparment_create() : $this->deparment_update($id);
    }

    public function deparment_create()
    {
            return [
                'name'=>'required|unique:departments,name',
                'description'=>'required|max:255',
                'branch_id'=>['required','exists:branches,id'],
                'parent_department_id'=>'nullable|exists:departments,id',
                'head_employee_id'=>'nullable|exists:employees,id'
            ];
    }

    public function deparment_update($id)
    {
        return [
            'name'=>['required',Rule::unique('departments','name')->ignore($id)],
            'description'=>'required|max:255',
            'code'=>['required',Rule::unique('departments','code')->ignore($id)],
            'branch_id'=>['required','exists:branches,id'],
            'parent_department_id'=>['nullable','exists:departments,id',
    Rule::notIn([$id])],
            'head_employee_id'=>'nullable|exists:employees,id'
        ];
    }
}
