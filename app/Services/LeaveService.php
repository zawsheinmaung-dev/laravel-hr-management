<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\Leavetype;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class LeaveService
{
    public function get_index()
    {
        $leabeType = Leavetype::all();
        $leave_request = LeaveRequest::with('employee', 'leaveType')->paginate(20);
        return ['leavetype' => $leabeType, 'leaveRequest' => $leave_request, 'status' => config('status.leave.statuses')];
    }

    public function leave_show($id)
    {
        $leave = LeaveRequest::with('employee', 'leaveType', 'approvedBy')->find($id);
        $history = LeaveRequest::with('leaveType')->where('employee_id', $leave->employee_id)->where('id', '!=', $leave->id)->latest()
            ->get();
        $balance = LeaveBalance::with('leaveType')->where('employee_id', $leave->employee_id)->where('year', now()->year)->get();

        return [
            'leave' => $leave,
            'history' => $history,
            'balance' => $balance,
        ];
    }

    public function leave_store($data)
    {
        $emp_id = auth()->user()->employee->id;
        $leave_request = LeaveRequest::where('employee_id', $emp_id)->whereNotIn('status', ['rejected', 'cancelled'])->where(function ($q) use ($data) {
            $q->whereDate('start_date', '<=', $data['end_date'])
                ->whereDate('end_date', '>=', $data['start_date']);
        })->exists();
        if ($leave_request) {
            throw new Exception('Leave request already exists for this date');
        }

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $total = $start->diffInDays($end) + 1;

        $leave_balance = LeaveBalance::where('employee_id', $emp_id)->where('leavetype_id', $data['leavetype_id'])->where('year', now()->year)->first();
        if (!$leave_balance) {
            throw new Exception('That type of Leave can\'n get');
        }

        if ($total > $leave_balance->remaining_days) {
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

    public function leave_update($id, $status)
    {
        $leave_request = LeaveRequest::find($id);
        $leave_balance = LeaveBalance::where('employee_id', $leave_request->employee_id)->where('leavetype_id', $leave_request->leavetype_id)->where('year', now()->year)->first();

        if ($leave_request->status !== 'pending') {
            throw new Exception('Only pending leave requests can be updated.');
        }

        if ($status === 'approved') {
            if ($leave_balance->remaining_days < $leave_request->total_days) {
                throw new Exception('Remaining leave balance not enought.');
            }
            DB::transaction(function () use ($status, $leave_request, $leave_balance) {
                $leave_request->update([
                    'status' => $status,
                    'approved_by' => auth()->id(),
                    'approved_at' => now()
                ]);
                $leave_balance->update([
                    'used_days' => $leave_balance->used_days + $leave_request->total_days,
                    'remaining_days' => $leave_balance->remaining_days - $leave_request->total_days,
                ]);

                $att = Attendance::firstOrNew([
                    'employee_id' => $leave_request->employee_id,
                    'attendance_date' => now()->toDateString(),
                    'status' => 'leave',
                ]);
                $att->save();
                AttendanceLog::create([
                    'employee_id' => auth()->id(),
                    'log_time' => now(),
                    'log_type' => 'leave_request'
                ]);
            });
        } else {
            $leave_request->update([
                'status' => $status,
                'approved_by' => auth()->id(),
                'approved_at' => now()->toDateString()
            ]);
        }
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

            $leave_type = Leavetype::where('name', $leave_name)->first();
            if (!$leave_type) {
                continue;
            }
            $balance = LeaveBalance::firstOrNew(
                ['employee_id' => $employee->id, 'leavetype_id' => $leave_type->id, 'year' => now()->year],
                ['allocated_days' => $day, 'used_days' => 0, 'remaining_days' => $day]
            );
            $balance->allocated_days = $day;
            $balance->remaining_days = $day - $balance->used_days;
            $balance->save();
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
