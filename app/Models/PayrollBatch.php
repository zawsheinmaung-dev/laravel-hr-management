<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollBatch extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollBatchesFactory> */
    use HasFactory;
    protected $fillable = [
        'month',
        'year',
        'generated_by',
        'status'
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    
}
