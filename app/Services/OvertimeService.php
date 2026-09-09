<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Overtime;
use Exception;
use Illuminate\Support\Facades\DB;

class OvertimeService
{
    public function index()
    {
        return Overtime::with('employee')->get();
    }

    public function store($data)
    {
        $emp_id = auth()->user()->employee->id;
        $att = Attendance::where('employee_id', $emp_id)->whereDate('attendance_date', $data['date'])->first();

        if (!$att) {
            throw new Exception('Not working this day');
        }

        $ot = Overtime::where('employee_id', $emp_id)->whereDate('date', $data['date'])
        ->where('status','!=','rejected')->first();
        if ($ot) {
            throw new Exception('Overtime request already exists for this day.');
        }

        Overtime::create([
            'employee_id' => $emp_id,
            'attendance_id' => $att->id,
            'date' => $data['date'],
            'from_time' => $data['from_time'],
            'to_time' => $data['to_time'],
            'reason' => $data['reason'],
            'status' => 'pending'
        ]);
    }

    public function update($id, $status)
    {
        $ot = Overtime::find($id);
        if (!$ot) {
            throw new Exception('Something wrong please connect to IT_Admin');
        }
        DB::transaction(function () use ($ot, $status) {
            if($ot->status !=='pending')
                {
                    throw new Exception('Only pending leave requests can be approved.');
                }
            $ot->update([
                'approved_by' => auth()->id(),
                'status' => $status
            ]);
            if ($status === 'approved') {
                $ot->attendance->update([
                    'overtime_minutes' => $ot->from_time->diffInMinutes($ot->to_time)
                ]);
            }
        });
    }
}
