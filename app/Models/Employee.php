<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\SearchTrait;

class Employee extends Model
{

    use HasFactory,SoftDeletes,SearchTrait;

    protected $fillable = [
    'user_id',
    'department_id',
    'position_id',
    'branch_id',
    'salary_structure_id',

    'first_name',
    'last_name',
    'gender',
    'dob',
    'national_id',
    'phone',
    'personal_email',
    'address',

    'employment_type',
    'employment_status',
    'join_date',
    'resign_date',
    'manager_id',
    'basic_salary',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class,'manager_id');
    }

    public function directReports()
    {
        return $this->hasMany(Employee::class,'manager_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function currentShift()
    {
        return $this->hasOne(ShiftAssignments::class,'employee_id');
    }

    public function shiftAssig()
    {
        return $this->hasMany(ShiftAssignments::class,'employee_id');
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function update_user_name()
    {
        $this->user()->update([
            'name'=>$this->first_name.' '.$this->last_name
        ]);
    }
    
}
