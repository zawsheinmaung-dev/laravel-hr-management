<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollFactory> */
    use HasFactory;
    protected $fillable = [
        'payroll_batch_id',
        'employee_id',
        'basic_salary',
        'total_allowance',
        'total_bonus',
        'total_deduction',
        'tax',
        'net_salary',
        'status',
        'generated_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollBatch()
    {
        return $this->belongsTo(PayrollBatch::class);
    }
}
