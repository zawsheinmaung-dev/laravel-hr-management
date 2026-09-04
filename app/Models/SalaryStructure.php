<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    /** @use HasFactory<\Database\Factories\SalaryStructureFactory> */
    use HasFactory;

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
