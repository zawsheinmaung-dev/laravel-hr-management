<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    /** @use HasFactory<\Database\Factories\SalaryStructureFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function salaryStructureItems()
    {
        return $this->hasMany(SalaryStructureItem::class,'salary_structure_id');
    }
}
