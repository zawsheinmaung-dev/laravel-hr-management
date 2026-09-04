<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_department_id',
        'head_employee_id',
        'branch_id',
        'description'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function headEmp()
    {
        return $this->belongsTo(Employee::class,'head_employee_id');
    }

    public function parentDep()
    {
        return $this->belongsTo(Department::class,'parent_department_id');
    }

    public function childrenDep()
    {
        return $this->hasMany(Department::class,'parent_department_id');
    }

    public function position()
    {
        return $this->hasMany(Position::class);
    }
   
}
