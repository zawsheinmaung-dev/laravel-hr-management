<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\Shifts;
use Exception;
use Illuminate\Support\Facades\DB;


class PayrollService
{
    public function __construct(protected PayrollCalculationService $payroll_calculation) {}

    public function get_index()
    {
        return PayrollBatch::where('year', now()->year)
            ->withCount('payrolls')
            ->withSum('payrolls', 'net_salary')
            ->get();
    }

    public function get_show($id)
    {
        return PayrollBatch::with('payrolls.employee.department')->withCount('payrolls')
            ->withSum('payrolls', 'net_salary')->find($id);
    }

    public function generate($month, $year)
    {

        if ($month != now()->month || $year != now()->year) {
            throw new Exception('Payroll can only be generated for this month.');
        }

        $exists = PayrollBatch::where('month', $month)
            ->where('year', $year)
            ->exists();

        if ($exists) {
            throw new Exception('Payroll for this month has already been generated.');
        }

        $employees = Employee::with(
            [
                'salaryStructure.salaryStructureItems.salaryComponent',
                'attendances' => function ($qu) use ($month, $year) {
                    $qu->whereMonth('attendance_date', $month)->whereYear('attendance_date', $year);
                },
                'currentShift'
            ]
        )->get();

        DB::transaction(function () use ($month, $year, $employees) {

            $payroll_batch = PayrollBatch::create([
                'month' => $month,
                'year' => $year,
                'generated_by' => auth()->id(),
                'status' => 'generated'
            ]);
            foreach ($employees as $emp) {
                $calculate = $this->payroll_calculation->calculate($emp, $month, $year);

                $payroll = Payroll::create([
                    'payroll_batch_id' => $payroll_batch->id,
                    'employee_id' => $emp->id,
                    'basic_salary' => $calculate['basic_salary'],
                    'total_allowance' => $calculate['total_allowance'],
                    'total_bonus' => 0,
                    'total_deduction' => round($calculate['total_deduction'],2),
                    'tax' => round($calculate['tax'],2),
                    'net_salary' => round($calculate['net_salary'], 2),
                    'status' => $payroll_batch->status,
                    'generated_at' => now()->toDateString()
                ]);
                $this->payroll_calculation->addPayRollItems(
                    $payroll,
                    $calculate['housing_allowance'],
                    $calculate['transport_allowance'],
                    $calculate['tax'],
                    $calculate['deduction_salary']
                );
            }
        });
    }

    public function payroll_approved($id)
    {
        $payroll_batch = PayrollBatch::findOrFail($id);
        if ($payroll_batch->status != 'generated') {
            throw new Exception('Only generat payroll cna approve');
        }
        DB::transaction(function () use ($payroll_batch) {
            $payroll_batch->update(['status' => 'approved']);
            $payroll_batch->payrolls()->update(['status' => 'approved']);
        });
    }

    public function payroll_paid($id)
    {
        $payroll_batch = PayrollBatch::findOrFail($id);
        if ($payroll_batch->status != 'approved') {
            throw new Exception('Only approved payroll cna approve');
        }
        DB::transaction(function () use ($payroll_batch) {
            $payroll_batch->update(['status' => 'paid']);
            $payroll_batch->payrolls()->update(['status' => 'paid']);
        });
    }

    public function employeeView($id)
    {
        return Employee::with(['payrolls.payrollBatch', 'department', 'position', 'salaryStructure.salaryStructureItems' => function ($q) {
            $q->whereHas('salaryComponent', function ($q) {
                $q->where('name', 'Basic Salary');
            });
        }])->findOrFail($id);
    }

    public function payslipView($id)
    {
        return Payroll::with('employee.department', 'employee.position', 'payrollBatch', 'items')->findOrFail($id);
    }
}
