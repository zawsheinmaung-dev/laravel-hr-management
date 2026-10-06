<?php

namespace App\Services;

use App\Models\Holiday;
use App\Models\Shifts;
use App\Models\TaxBracket;
use Carbon\Carbon;

class PayrollCalculationService
{
    public function calculate($emp, $month, $year)
    {
      
        $workingDays = $this->perDay($emp->currentShift->shift_id, $month, $year);
        
        $basic_salary = $this->getAmount($emp,'Basic Salary');
        $housing_allowance = $this->getAmount($emp,'Housing Allowance');
        $transport_allowance = $this->getAmount($emp,'Transport Allowance');

        $att_count = $emp->attendances->whereIn('status', ['present','late'])->count();
        $daily_salary = 0;
        if($workingDays > 0)
            {
                $daily_salary = $basic_salary / $workingDays;
            }

        $tax = $this->calculateTax($basic_salary);
        
        $deduction_salary = 0;
        
        if ($workingDays > $att_count) {
            $deduction_salary = ($workingDays - $att_count) * $daily_salary;
        }

        $total_deduction = $deduction_salary + $tax;
        $total_allowance = $housing_allowance + $transport_allowance;

        $net_salary = ($basic_salary - $total_deduction) + $total_allowance ;
        return [
            'basic_salary' => $basic_salary,
            'housing_allowance' => $housing_allowance,
            'transport_allowance' => $transport_allowance,
            'tax' => $tax,
            'deduction_salary' => $deduction_salary,
            'total_deduction' => $total_deduction,
            'total_allowance' => $total_allowance,
            'net_salary' => $net_salary
        ];
    }

    public function perDay($shiftId, $month, $year)
    {
        
        $start_day = Carbon::create($year, $month, 1);
        $end_day = $start_day->copy()->endOfMonth();
        $workingDaysCount = 0;

        $shift = Shifts::with(['workingDays' => function ($qu) {
            $qu->where('is_working', true);
        }])->findOrFail($shiftId);

        $workingDays = $shift->workingDays->pluck('name');

        $holidays = Holiday::whereYear('holiday_date', $year)->whereMonth('holiday_date', $month)->pluck('holiday_date');

        while ($start_day->lte($end_day)) // lte = less than or equal
        {
            $days = $start_day->format('l');
            $date = $start_day->format('Y-m-d');

            if ($workingDays->contains($days)) {
                if (!$holidays->contains($date)) {
                    $workingDaysCount++;
                }
            }

            $start_day->addDay(); // $strat_day ++
        }

        return $workingDaysCount;
    }

    public function calculateTax($basic_salary)
    {
        $taxRate = TaxBracket::where('min_amount', '<=', $basic_salary)->where(function($qu) use($basic_salary){
            $qu->where('max_amount', '>=', $basic_salary)
            ->orWhereNull('max_amount');

        })->value('rate_percentage') ?? 0;
        return $basic_salary * ($taxRate / 100);
    }

    public function addPayRollItems(
        $payroll,
        $housing_allowance,
        $transport_allowance,
        $tax,
        $deduction_salary
    ) {
        $items = [
            [
                'item_type' => 'basic',
                'description' => 'Basic Salary',
                'amount' => round($payroll->basic_salary, 2),
            ],

            [
                'item_type' => 'allowance',
                'description' => 'Housing Allowance',
                'amount' => round($housing_allowance, 2),
            ],

            [
                'item_type' => 'allowance',
                'description' => 'Transport Allowance',
                'amount' => round($transport_allowance, 2),
            ],
            [
                'item_type' => 'deduction',
                'description' => 'Income Tax',
                'amount' => round($tax, 2),
            ],
            [
                'item_type' => 'deduction',
                'description' => 'Attendance Deduction',
                'amount' => round($deduction_salary, 2),
            ],

        ];

        foreach ($items as $item) {
            if ($item['amount'] > 0) {
                $payroll->items()->create($item);
            }
        }
    }

    public function getAmount($emp, $name)
    {
        return $emp->salaryStructure->salaryStructureItems
            ->first(function ($item) use ($name) {
                return $item->salaryComponent->name === $name;
            })?->amount ?? 0;

    }
}
