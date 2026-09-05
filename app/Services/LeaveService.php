<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class LeaveService
{
    public function get_index()
    {
        $leabeType =Leavetype::all();
        $leave_request=LeaveRequest::with('employee','leaveType')->paginate(20);
        return ['leavetype'=>$leabeType,'leaveRequest'=>$leave_request];
    }
    public function leave_store($data)
    {
        $emp_id = auth()->user()->employee->id;
        $leave_balance = LeaveBalance::where('employee_id', $emp_id)->where('leavetype_id', $data['leavetype_id'])->where('year',now()->year)->first();

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $total = $start->diffInDays($end) +1;

        if (!$leave_balance) {
            throw new Exception('That type of Leave can\'n get');
        }

        if($total > $leave_balance->remaining_days)
            {
                throw new Exception('Leave Balance not enought');
            }
        
        LeaveRequest::create([
            'employee_id' => $emp_id,
            'leavetype_id' => $data['leavetype_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_days' => $total,
            'reason' => $data['reason']
        ]);
    }


    public function sync($employeeId, $new_status): void
    {
        $employee = Employee::find($employeeId);
        $join_date = Carbon::parse($employee->join_date);
        $today = now();
        $joining_date = $this->getJoinData($join_date, $today);
        if (!$joining_date) {
            return;
        }
        $emp_get_leave = $this->addLeaveBalance($joining_date);
        foreach ($emp_get_leave as $leave_name => $day) {

            $leave_type = LeaveType::where('name', $leave_name)->first();
            if (!$leave_type) {
                continue;
            }
            $balance = LeaveBalance::create([
                'employee_id' => $employee->id,
                'leavetype_id' => $leave_type->id,
                'year' => now()->year,
                'allocated_days' => $day,
                'used_days' => 0,
                'remaining_days' => $day,
            ]);

            $allow_day = $balance->allocated_days ?? 0;
            $use_day = $balance->used_days ?? 0;

            if ($allow_day < $day) {
                $diff = $day - $allow_day;
                $balance->allocated_days = $diff + $allow_day;
                $balance->used_days = $use_day;
                $balance->remaining_days = $balance->allocated_days - $balance->used_days;
                $balance->save();
            } else {
                if (!$balance->exists) {
                    $balance->allocated_days = $day;
                    $balance->used_days = 0;
                    $balance->remaining_days = $day;

                    $balance->save();
                }
            }
        }
    }


    private function getJoinData(Carbon $join_date, Carbon $today)
    {
        if ($today->lt($join_date->copy()->addMonths(3))) {
            return;
        }
        if ($today->lt($join_date->copy()->addMonths(6))) {
            return '3_month';
        }
        if ($today->lt($join_date->copy()->addMonths(12))) {
            return '6_month';
        }
        return '12_month';
    }

    private function addLeaveBalance($joining)
    {
        return match ($joining) {
            '3_month' => [
                'ANNUAL' => 3,
                'SICK'   => 10,
                'CASUAL' => 2,
            ],

            '6_month' => [
                'ANNUAL' => 6,
                'SICK'   => 20,
                'CASUAL' => 4,
            ],

            '12_month' => [
                'ANNUAL' => 10,
                'SICK'   => 30,
                'CASUAL' => 6,
            ],
        };
    }
}
