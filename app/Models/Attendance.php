<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function atttendanceLog()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function overtime()
    {
        return $this->belongsTo(Attendance::class);
    }
}
