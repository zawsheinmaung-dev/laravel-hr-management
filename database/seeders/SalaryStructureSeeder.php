<?php

namespace Database\Seeders;

use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureItem;
use Illuminate\Database\Seeder;

class SalaryStructureSeeder extends Seeder
{
    public function run(): void
    {
        // Salary Components
        $basicSalary = SalaryComponent::create([
            'name' => 'Basic Salary',
            'type' => 'earning',
            'description' => 'Employee basic monthly salary',
        ]);

        $housing = SalaryComponent::create([
            'name' => 'Housing Allowance',
            'type' => 'earning',
            'description' => 'Monthly housing allowance',
        ]);

        $transport = SalaryComponent::create([
            'name' => 'Transport Allowance',
            'type' => 'earning',
            'description' => 'Monthly transport allowance',
        ]);

        $tax = SalaryComponent::create([
            'name' => 'Income Tax',
            'type' => 'deduction',
            'description' => 'Employee income tax',
        ]);

        // Salary Structure
        $structure = SalaryStructure::create([
            'name' => 'Monthly Staff Salary',
            'description' => 'Standard monthly salary structure for staff',
        ]);

        // Salary Structure Items
        SalaryStructureItem::create([
            'salary_structure_id' => $structure->id,
            'salary_component_id' => $basicSalary->id,
            'calculation_type' => 'fixed',
            'amount' => 500000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
            'end_date' => null,
        ]);

        SalaryStructureItem::create([
            'salary_structure_id' => $structure->id,
            'salary_component_id' => $housing->id,
            'calculation_type' => 'fixed',
            'amount' => 100000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
            'end_date' => null,
        ]);

        SalaryStructureItem::create([
            'salary_structure_id' => $structure->id,
            'salary_component_id' => $transport->id,
            'calculation_type' => 'fixed',
            'amount' => 50000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
            'end_date' => null,
        ]);

        SalaryStructureItem::create([
            'salary_structure_id' => $structure->id,
            'salary_component_id' => $tax->id,
            'calculation_type' => 'percentage',
            'amount' => null,
            'percentage' => 5.00,
            'effective_date' => '2026-01-01',
            'end_date' => null,
        ]);
    }
}