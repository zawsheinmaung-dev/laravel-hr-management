<?php

namespace App\Services;

use App\Models\ShiftAssignments;
use App\Models\Shifts;
use Exception;

class ShiftService
{
    public function index()
    {
        return Shifts::with('assignments.employee')->get();
    }

    public function edit($id)
    {
        return $this->shif_with_assignment($id);
    }

    public function show($id)
    {
        return $this->shif_with_assignment($id);
    }

    public function shift_assign($data)
    {
        $day_check=ShiftAssignments::where('employee_id',$data['employee_id'])->whereDate('effective_date',$data['effective_date'])->exists();
        if($day_check)
            {
                throw new Exception('Employee has already assign this day');
            }
        // $active_now =ShiftAssignments::where('employee_id',$data['employee_id'])
        //                 ->where('effective_date','<=',now()->toString())->orderByDesc('effective_date')->first();
        // if($active_now)
        //     {
        //         throw new Exception('Employee on shift '.$active_now->shift_id. 'Effecitve date'.$active_now->effective_date);
        //     }
        return ShiftAssignments::create($data);
    }

    public function shift_delete($id)
    {
        $shift =Shifts::find($id);
        if($shift->assignments()->exists())
            {
                throw new Exception('Shift Cant\'t Delete: Shift hav assig');
            }
        $shift->delete();
    }

    public function shift_assign_delete($id)
    {
        
        $shift_assigm =ShiftAssignments::find($id);
        if($shift_assigm->effective_date <= now()->toDateString())
            {
                throw new Exception('Past Assign can\'n delete parmently');
            }
        $shift_assigm->delete();
    }

    private function shif_with_assignment($id)
    {
        $shift =Shifts::find($id);
        if(!$shift) return;
        $assig =$shift->assignments()->with(['employee.position','employee.department'])->orderByDesc('effective_date')->paginate(5);
        return ['shift'=>$shift,'assig'=>$assig];
    }
}