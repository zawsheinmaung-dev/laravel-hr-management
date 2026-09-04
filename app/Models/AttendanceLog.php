<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'log_type',
        'device',
        'ip_address',
        'gps_location',
        'log_time',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
