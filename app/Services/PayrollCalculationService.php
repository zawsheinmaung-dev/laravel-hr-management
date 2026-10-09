<?php


    namespace App\Services;

    use App\Models\Holiday;
    use App\Models\Shifts;
    use App\Models\TaxBracket;
    use Illuminate\Support\Carbon;

    class PayrollCalculationService
    {
        public function calculate($emp, $month, $year)
        {
            $workingDays = $this->perDay($emp->currentShift->shift_id, $month, $year);
            $basic_salary = $this->getAmount($emp, 'Basic Salary');
            $housing_allowance = $this->getAmount($emp, 'Housing Allowance');
            $transport_allowance = $this->getAmount($emp, 'Transport Allowance');
            $att_count = $emp->attendances->whereIn('status', ['present', 'late'])->count();
            $tax = $this->calculateTax($basic_salary);

            $daily_salary = 0;
            $deduction_salary = 0;

            if ($workingDays > 0) {
                $daily_salary = $basic_salary / $workingDays;
            }
            [$late_time, $early_out] = $this->emp_att($emp,$daily_salary);
            

            if ($workingDays > $att_count) {
                $deduction_salary = ($workingDays - $att_count) * $daily_salary;
            }
            $over_time =$this->calculateOvertime($emp,$daily_salary) ?? 0 ;
            $total_deduction = $deduction_salary + $tax + $late_time +$early_out;
            $total_allowance = $housing_allowance + $transport_allowance + $over_time;
            
            $net_salary = $basic_salary + $total_allowance - $total_deduction ;
            return [
                'basic_salary' => $basic_salary,
                'housing_allowance' => $housing_allowance,
                'transport_allowance' => $transport_allowance,
                'tax' => $tax,
                'deduction_salary' => $deduction_salary,
                'total_deduction' => $total_deduction,
                'total_allowance' => $total_allowance,
                'net_salary' => $net_salary,
                'late_minutes'=>$late_time,
                'early_out_minutes'=>$early_out,
                'over_time'=>$over_time
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

        private function calculateTax($basic_salary)
        {
            $taxRate = TaxBracket::where('min_amount', '<=', $basic_salary)->where(function ($qu) use ($basic_salary) {
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
            $deduction_salary,
            $late_time,
            $early_out,
            $ovet_time
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
                [
                    'item_type' => 'allowance',
                    'description' => 'Over time',
                    'amount' => round($ovet_time, 2),
                ],
                [
                    'item_type' => 'deduction',
                    'description' => 'Late Deduction',
                    'amount' => round($late_time, 2),
                ],
                [
                    'item_type' => 'deduction',
                    'description' => 'Early Leave Deduction',
                    'amount' => round($early_out, 2),
                ],

            ];

            foreach ($items as $item) {
                if ($item['amount'] > 0) {
                    $payroll->items()->create($item);
                }
            }
        }

        private function getAmount($emp, $name)
        {
            return $emp->salaryStructure->salaryStructureItems
                ->first(function ($item) use ($name) {
                    return $item->salaryComponent->name === $name;
                })?->amount ?? 0;
        }

        private function emp_att($emp, $daily_salary)
        {
            $late_time  = 0;
            $early_out = 0;
            foreach ($emp->attendances as $attendances)
                {
                    $late_time +=$this->calculateLateAndEarly($attendances->late_minutes,$daily_salary);
                    $early_out +=$this->calculateLateAndEarly($attendances->early_leave_minutes,$daily_salary);
                }
            return [
                round($late_time,2),
                round($early_out,2)
            ];
        }

        private function calculateLateAndEarly($minutes, $daily_salary)
        {
            foreach (config('attendance.attendance_rules') as $rule) {
                if ($minutes >= $rule['minutes']) {
                    if ($rule['type'] == 'half_day') {
                        return $daily_salary / 2;
                    }
                    return $rule['deduction'];
                }
            }
            return 0;
        }

        private function calculateOvertime($emp,$daily_salary)
        {
            $workingHours =$this->workingHours($emp);
            if($workingHours <= 0 || $daily_salary <= 0)
                {
                    return 0;
                }
            $over_time =$emp->overtimes->sum(function($qu){
                $from_time =Carbon::parse($qu->from_time);
                $to_time =Carbon::parse($qu->to_time);
                return $from_time->diffInMinutes($to_time) /60;
            });
            return round($over_time * ($daily_salary/$workingHours),2);
        }

        private function workingHours($emp)
        {
        $shift=$emp->currentShift?->shift;
        if(!$shift)
            {
                return 0;
            }

            return Carbon::parse($shift->start_time)->diffInMinutes(Carbon::parse($shift->end_time)) / 60;
        }
    }
