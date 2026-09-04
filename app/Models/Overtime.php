<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Overtime extends Model
{
    /** @use HasFactory<\Database\Factories\OvertimeFactory> */
    use HasFactory;

    protected $fillable = [
        'date',
        'from_time',
        'to_time',
        'reason',
        'employee_id',
        'attendance_id',
        'status',
        'approved_by'
    ];
    protected $appends = ['hours'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    protected function hours(): Attribute
    {
       return Attribute::make(
        get: fn()=>abs(
            Carbon::parse($this->from_time)->diffInMinutes(Carbon::parse($this->to_time))
        )/60
       );
    }
}
