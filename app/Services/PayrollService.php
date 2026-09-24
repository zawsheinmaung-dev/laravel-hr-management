<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\PayrollItem;
use Exception;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function get_index()
    {
        return PayrollBatch::where('month', now()->month)
            ->where('year', now()->year)
            ->withCount('payrolls')
            ->withSum('payrolls', 'net_salary')
            ->get();
    }

    public function get_show($id) 
    {
        return PayrollBatch::with('payrolls.employee.department','payrolls.employee.department')->find($id);
    }

    public static function generate($month, $year)
    {
        if ($month != now()->month || $year != now()->year) {
            throw new Exception('Payroll can only be generated for this month.');
        }
        $employee = Employee::with(
            'salaryStructure.salaryStructureItems.salaryComponent',
            'attendances'
        )->get();
        $payroll_batch = PayrollBatch::create([
            'month' => $month,
            'year' => $year,
            'generated_by' => auth()->id(),
            'status' => 'generated'
        ]);
        foreach ($employee as $emp) {
            $basic_salary = $emp->salaryStructure->salaryStructureItems
                ->first(function ($item) {
                    return $item->salaryComponent->name == 'Basic Salary';
                })->amount ?? 0;
            $housing_allowance = $emp->salaryStructure->salaryStructureItems
                ->first(function ($item) {
                    return $item->salaryComponent->name == 'Housing Allowance';
                })->amount ?? 0;
            $transport_allowance = $emp->salaryStructure->salaryStructureItems
                ->first(function ($item) {
                    return $item->salaryComponent->name == 'Transport Allowance';
                })->amount ?? 0;
            $att_count = $emp->attendances->where('status', 'present')->count();
            $salary = (($basic_salary / 30) * $att_count) + $housing_allowance + $transport_allowance;

            DB::transaction(function () use ($payroll_batch, $salary, $basic_salary, $emp, $transport_allowance, $housing_allowance) {

                $payroll = Payroll::create([
                    'payroll_batch_id' => $payroll_batch->id,
                    'employee_id' => $emp->id,
                    'basic_salary' => $basic_salary,
                    'total_allowance' => $housing_allowance + $transport_allowance,
                    'total_bonus' => 0,
                    'total_deduction' => 0,
                    'tax' => 0,
                    'net_salary' => round($salary, 2),
                    'status' => $payroll_batch->status,
                    'generated_at' => now()->toDateString()
                ]);
                PayrollItem::create([
                    'payroll_id'  => $payroll->id,
                    'item_type'   => 'basic',
                    'description' => 'Basic Salary',
                    'amount'      => round($payroll->basic_salary, 2),
                ]);
                PayrollItem::create([
                    'payroll_id'  => $payroll->id,
                    'item_type'   => 'allowance',
                    'description' => 'Housing Allowance',
                    'amount'      => $housing_allowance,
                ]);

                PayrollItem::create([
                    'payroll_id'  => $payroll->id,
                    'item_type'   => 'allowance',
                    'description' => 'Transport Allowance',
                    'amount'      => $transport_allowance,
                ]);
            });
        }
    }
}
