<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
       return $this->isMethod('POST') ? $this->create_employee() : $this->update_employee();
    }

    public function create_employee()
    {
        return [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'gender'            => ['required', 'in:male,female,other'],
            'dob'               => ['required', 'date'],
            'national_id'       => ['required', 'unique:employees,national_id'],
            'phone'             => ['required', 'string', 'max:255'],
            'personal_email'    => ['nullable', 'email'],
            'address'           => ['required', 'string'],

            'branch_id'         => ['required', 'exists:branches,id'],
            'department_id'     => ['required', 'exists:departments,id'],
            'position_id'       => ['required', 'exists:positions,id'],
            'manager_id'       => ['required', 'exists:employees,id'],

            'employment_type'   => ['required'],

            'join_date'         => ['required', 'date'],
        ];
    }

    public function update_employee()
    {
         return [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'gender'            => ['required', 'in:male,female,other'],
            'dob'               => ['required', 'date'],
            'national_id'       => ['required', 'exists:employees,national_id'],
            'phone'             => ['required', 'string', 'max:255'],
            'personal_email'    => ['nullable', 'email'],
            'address'           => ['required', 'string'],

            'branch_id'         => ['required', 'exists:branches,id'],
            'department_id'     => ['required', 'exists:departments,id'],
            'manager_id'       => ['required', 'exists:employees,id'],
            'position_id'       => ['required', 'exists:positions,id'],
            'salary_structure_id' => ['nullable', 'exists:salary_structures,id'],

            'employment_type'   => ['required'],
            'employment_status' => ['required'],

            'join_date'         => ['required', 'date'],
            'resign_date'       => ['nullable', 'date'],

            'basic_salary'      => ['required', 'numeric', 'min:0'],
        ];
    }
}
