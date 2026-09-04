<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    /** @use HasFactory<\Database\Factories\ShiftsFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'grace_minutes',
        'break_minutes'
    ];

    public function assignments()
    {
        return $this->hasMany(ShiftAssignments::class,'shift_id');
    }
}
