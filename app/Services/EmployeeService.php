<?php
namespace App\Services;

use App\Helpers\CodeGenerator;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function __construct(protected LeaveService $leave_balance)
    {
       
    }

    public function search($search)
    {
        $emp =Employee::search($search,['first_name','last_name','personal_email','employee_code'])->limit(5)->get();
        return $emp->load('department','user');
    }


    public function create_user_employee(array $user_data)
    {
        return DB::transaction(function () use ($user_data) {
            $email = $this->generate_user_email($user_data['first_name'], $user_data['last_name']);

            $user = User::create([
                'name' => $user_data['first_name'] . ' ' . $user_data['last_name'],
                'email' => $email,
                'password' => Hash::make('password')
            ]);

            $user->assignRole('employee');
            $user_data['user_id'] = $user->id;
            $emp = Employee::create($user_data);
            $emp->employee_code = CodeGenerator::generate('EMP-',$emp->id,4);
            $emp->save();
            
        });
    }
    
    public function edit_emp($id)
    {
        $employee = Employee::with('user',
            'department',
            'position',
            'branch',
            'manager',
            'salaryStructure')->find($id);
        return['employee'=>$employee,'department'=>Department::all(),'branch'=>Branch::all(),'position'=>Position::all()];
    }

    public function emp_update($id,$data)
    {
        $employee =Employee::find($id);
        $old_status =$employee->employment_status;
        $new_status=$data['employment_status'];
        
        if($old_status  !=='permanent' && $new_status ==='permanent')
            {
                DB::transaction(function () use ($id,$data,$employee)
                {
                    $employee->update($data);
                    $this->leave_balance->sync($id,$data['employment_status']);
                });
            }else{
                $employee->update($data);
            }
        
        
    }

    public function delete_user_emp($id)
    {
        return DB::transaction(function () use ($id){
            $emp =Employee::find($id);
            $emp->user?->delete();
            $emp->delete();
        });
    }

    private function generate_user_email($first_name, $last_name)
    {
        $base = strtolower(str_replace(' ','',trim($first_name) . trim($last_name)));
        $email = $base . '@hr.com';
        $count = 1;
        while (User::where('email', $email)->exists()) {
            $email = $base . $count . '@hr.com';
            $count++;
        }
        return $email;
    }
}
