<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leavetype_id',
        'start_date',
        'end_date',
        'total_days',
        'status',
        'approved_at',
        'approved_by',
        'reason'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(Leavetype::class,'leavetype_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Employee::class,'approved_by');
    }
}
