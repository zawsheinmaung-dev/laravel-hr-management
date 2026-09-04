<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftAssignments extends Model
{
    /** @use HasFactory<\Database\Factories\ShiftAssignmentsFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'shift_id',
        'effective_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class);
    }
}
