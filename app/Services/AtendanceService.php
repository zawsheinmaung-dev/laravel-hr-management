<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Employee;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\form;

class AtendanceService
{
    public function index()
    {
        return Attendance::with('employee')->get();
    }

    public function check_in($date)
    {
        $emp_id = auth()->user()->employee->id;
        $assign = $this->getAssign($emp_id);
        $attendace = $this->getAttendace($emp_id);
        $now = now();
        $late = 0;

        if ($attendace?->check_in) {
            throw new Exception('Already Check In');
        }

        if ($assign?->shift) {
            $start_time = Carbon::parse($assign->shift->start_time);
            $check = Carbon::parse($now->format('H:i:s'));
            if ($check->gt($start_time)) {
                $late = max(0, $start_time->diffInMinutes($check) - $assign->shift->grace_minutes);
            }
        }

        return DB::transaction(function () use ($emp_id, $now, $late, $date) {
            $att = Attendance::create([
                'employee_id' => $emp_id,
                'attendance_date' => now()->toDateString(),
                'check_in' => $now->format('H:i:s'),
                'check_in_ip' => $date,
                'late_minutes' => $late,
                'status' => $late > 0 ? 'late' : 'present',
            ]);
            AttendanceLog::create([
                'employee_id' => $emp_id,
                'log_time' => now(),
                'ip_address' => $date
            ]);
        });
    }

    public function check_out()
    {
        $emp_id = auth()->user()->employee->id;
        $assign = $this->getAssign($emp_id);
        $attendace = $this->getAttendace($emp_id);

        $start_time = Carbon::parse($assign->shift->start_time);
        $end_time = Carbon::parse($assign->shift->end_time);
        $now = Carbon::parse(now()->format('H:i:s'));
        $check_in = Carbon::parse($attendace->check_in);
        $working = number_format($check_in->diffInHours($now), 2);
        $early_out = $now->lt($end_time) ? max(0, $now->diffInMinutes($end_time)) : 0;
        return DB::transaction(function () use ($emp_id, $working, $early_out, $attendace) {
            $attendace->update([
                'check_out' => now()->format('H:i:s'),
                'working_hours' => $working,
                'early_leave_minutes' => $early_out
            ]);
            AttendanceLog::create([
                'employee_id' => $emp_id,
                'log_time' => now(),
                'log_type' => 'check_out'
            ]);
        });
    }

    private function getAssign($id)
    {
        $emp = Employee::find($id);
        return $emp->shiftAssig()->where('effective_date', '<=', now()->toDateString())->latest('effective_date')->first();
    }

    private function getAttendace($id)
    {
        return Attendance::where('employee_id', $id)->whereDate('attendance_date', now()->toDateString())->first();
    }
}
