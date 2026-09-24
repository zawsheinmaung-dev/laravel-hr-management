<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollItemFactory> */
    use HasFactory;
    protected $fillable = [
        'payroll_id',
        'item_type',
        'description',
        'amount'
    ];
}
