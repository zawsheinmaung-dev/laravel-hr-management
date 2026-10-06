<?php

namespace App\Services;

use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureItem;
use Illuminate\Support\Facades\DB;

class SalaryService
{
    public function get_index()
    {
        return SalaryComponent::all();
    }

    public function store_salary($component, $structure, $item)
    {
        dd($item);
        DB::transaction(function () use ($component, $structure, $item) {
            $comp = SalaryComponent::create($component);
            $stu = SalaryStructure::create([
                    'name' => $structure['structure_name'],
                    'description' => $structure['structure_description']
                ]);
                SalaryStructureItem::create([
                    'salary_structure_id' => $stu->id,
                    'salary_component_id' => $comp->id,
                    'calculation_type' => $item['calculation_type'],
                    'amount' => $item['amount'],
                    'percentage' => $item['percentage'],
                    'effective_date' => $item['effective_date']
                ]);

        });
    }

    public function edit_salary($id)
    {
        return SalaryComponent::with('salaryComponentItems', 'salaryStructures')->findOrFail($id);
    }

    public function update_salary($id, $component, $structure, $items)
    {
        dd('items',$items,$structure);
        DB::transaction(function () use ($id, $component, $structure, $items) {
            $comp = SalaryComponent::findOrFail($id);
            $comp->update($component);
            $stu = SalaryStructure::updateOrCreate(
                [
                    $structure->id
                ],
                [
                    'name' => $structure['structure_name'],
                    'description' => $structure['structure_description'],
                ]
            );

            SalaryStructureItem::where('salary_structure_id', $stu->id)
                ->where('salary_component_id', $comp->id)
                ->delete();

            foreach ($items as $item) {
                SalaryStructureItem::create([
                    'salary_structure_id' => $stu->id,
                    'salary_component_id' => $comp->id,
                    'calculation_type' => $item['calculation_type'],
                    'amount' => $item['amount'],
                    'percentage' => $item['percentage'],
                    'effective_date' => $item['effective_date'],
                ]);
            }
        });
    }

    public function delete_salary($id)
    {
        $salary = SalaryComponent::findOrFail($id);
        $salary->delete();
    }
}
