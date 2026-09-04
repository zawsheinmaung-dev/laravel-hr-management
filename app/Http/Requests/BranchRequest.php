<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        return $this->method("POST") ? $this->create_branches() : $this->update_branches();
    }

    public function create_branches()
    {
        return [
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'manager_id'=>'required',

        ];
    }

    public function update_branches()
    {
        return [
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'manager_id'=>'required|exists:employees,id'

        ];
    }
}
