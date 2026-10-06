<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    /** @use HasFactory<\Database\Factories\AllowanceFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'salary_component_id',
        'calculation_type',
        'amount',
        'effective_date'
    ];
}
