<?php

namespace App\Services;

use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use Illuminate\Support\Facades\DB;

class SalaryStructureService
{
    public function get_index()
    {
        return SalaryStructure::with('salaryStructureItems')->get();
    }

    public function store_items($structure, $items)
    {
        DB::transaction(function () use ($structure, $items) {
            $structure = SalaryStructure::create($structure);
            foreach ($items as $item) {
                $structure->salaryStructureItems()->create($item);
            }
        });
    }

    public function update_comp($id, $structure, $items)
    {
        $salary_structure = SalaryStructure::findOrFail($id);
        DB::transaction(function () use ($items, $salary_structure, $structure) {
            $salary_structure->update($structure);
            $salary_structure->salaryStructureItems()->delete();
            foreach ($items as $item) {
                if (!empty($item['id'])) {
                    $salary_structure->salaryStructureItems()->create(
                       $item
                    );
                } 
            }
        });
    }
}
