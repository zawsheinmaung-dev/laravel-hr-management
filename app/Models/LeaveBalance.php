<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leavetype_id',
        'year',
        'allocated_days',
        'used_days',
        'remaining_days'
    ];

    public function leaveType()
    {
        return $this->belongsTo(Leavetype::class,'leavetype_id');
    }
}
