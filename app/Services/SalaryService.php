<?php

namespace App\Services;

use App\Models\SalaryComponent;
use App\Models\SalaryStructure;

class SalaryService
{
    public function get_index()
    {
        return SalaryComponent::all();
    }

    public function store_salary($data)
    {
        SalaryComponent::create($data);
    }

    public function edit_salary($id)
    {
        return SalaryComponent::findOrFail($id);
    }

    public function update_salary($data,$id)
    {
        $salary =SalaryComponent::findOrFail($id);
        $salary->update($data);
    }

    public function delete_salary($id)
    {
        $salary =SalaryComponent::findOrFail($id);
        $salary->delete();
    }
}