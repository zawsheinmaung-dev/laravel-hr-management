<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Employees;
use App\Models\Leavetype;
use App\Models\Overtime;
use App\Models\Position;
use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureItem;
use App\Models\ShiftAssignments;
use App\Models\Shifts;
use App\Models\TaxBracket;
use App\Models\User;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Database\Factories\AttendanceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Users
        User::factory(50)->create()->each(function ($user) {
            $role = Role::inRandomOrder()->first();

            $user->assignRole($role);
        });

        // Organization
        Branch::factory(5)->create();
        Department::factory(5)->create();
        Position::factory(10)->create();

        // Employees
        User::whereDoesntHave('employee')->each(function ($user) {
            $name = explode(' ', trim($user->name), 2);

            Employee::factory()->create([
                'user_id' => $user->id,
                'first_name' => $name[0],
                'last_name' => $name[1] ?? null,
                'personal_email' => fake()->unique()->safeEmail(),
                'branch_id' => Branch::inRandomOrder()->value('id'),
                'department_id' => Department::inRandomOrder()->value('id'),
                'position_id' => Position::inRandomOrder()->value('id'),
            ]);
        });

        // Leave Types
        LeaveType::create([
            'name' => 'ANNUAL',
            'days_allowed_per_year' => 10,
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'SICK',
            'days_allowed_per_year' => 30,
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'CASUAL',
            'days_allowed_per_year' => 6,
            'is_paid' => true,
        ]);

        LeaveType::create([
            'name' => 'UNPAID',
            'days_allowed_per_year' => 0,
            'is_paid' => false,
        ]);

        //Shift
        $shift = Shifts::create([
            'name' => 'SHIFT-1',
            'start_time' => '9:00',
            'end_time' => '17:00',
            'grace_minutes' => '10',
            'break_minutes' => '60',
        ]);
        foreach (config('workingdays.days') as $day) {
            WorkingDay::create([
                'shift_id' => $shift->id,
                'name' => $day,
                'is_working' => in_array($day, [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                ])
            ]);
        }

        // Salary Components
        $basicSalary = SalaryComponent::create([
            'name' => 'Basic Salary',
            'type' => 'earning',
            'description' => 'Employee basic monthly salary',
        ]);

        $housing = SalaryComponent::create([
            'name' => 'Housing Allowance',
            'type' => 'earning',
            'description' => 'Monthly housing allowance',
        ]);

        $transport = SalaryComponent::create([
            'name' => 'Transport Allowance',
            'type' => 'earning',
            'description' => 'Monthly transport allowance',
        ]);

        $att_dud = SalaryComponent::create([
            'name' => 'Attendance Deduction',
            'type' => 'deduction',
            'description' => 'Deduction for absent working days',
        ]);

        $tax = SalaryComponent::create([
            'name' => 'Income Tax',
            'type' => 'deduction',
            'description' => 'Monthly income tax deduction',
        ]);

        $lateDeduction = SalaryComponent::create([
            'name' => 'Late Deduction',
            'type' => 'deduction',
            'description' => 'Deduction for late arrival',
        ]);


        // Salary Structure
        $staffSalary = SalaryStructure::create([
            'name' => 'Monthly Staff Salary',
            'description' => 'Standard monthly salary structure for staff',
        ]);


        // Basic Salary
        SalaryStructureItem::create([
            'salary_structure_id' => $staffSalary->id,
            'salary_component_id' => $basicSalary->id,
            'calculation_type' => 'fixed',
            'amount' => 500000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
        ]);

        // Housing Allowance
        SalaryStructureItem::create([
            'salary_structure_id' => $staffSalary->id,
            'salary_component_id' => $housing->id,
            'calculation_type' => 'fixed',
            'amount' => 100000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
        ]);

        // Transport Allowance
        SalaryStructureItem::create([
            'salary_structure_id' => $staffSalary->id,
            'salary_component_id' => $transport->id,
            'calculation_type' => 'fixed',
            'amount' => 50000,
            'percentage' => null,
            'effective_date' => '2026-01-01',
        ]);


        $employees = Employee::all();
        // Shift Assign
        $amount = $staffSalary->salaryStructureItems
            ->firstWhere('salary_component_id', $basicSalary->id);
        foreach ($employees as $emp) {
            ShiftAssignments::create([
                'employee_id' => $emp->id,
                'shift_id' => $shift->id,
                'effective_date' => now()->today()
            ]);
            $emp->update([
                'salary_structure_id' => $staffSalary->id,
                'basic_salary' => $amount->amount
            ]);
        }



        /*
    |--------------------------------------------------------------------------
    | Income Tax
    |--------------------------------------------------------------------------
    |
    | Income Tax is NOT added as a SalaryStructureItem.
    |
    | Tax will be calculated in PayrollService using:
    |
    | Basic Salary
    |      ↓
    | Tax Brackets
    |      ↓
    | Progressive Tax
    |      ↓
    | Tax Amount
    |
    |--------------------------------------------------------------------------
    */


        // Tax Brackets
        TaxBracket::create([
            'min_amount' => 0,
            'max_amount' => 2000000,
            'rate_percentage' => 0,
            'effective_year' => 2026,
        ]);

        TaxBracket::create([
            'min_amount' => 2000000,
            'max_amount' => 5000000,
            'rate_percentage' => 5,
            'effective_year' => 2026,
        ]);

        TaxBracket::create([
            'min_amount' => 5000000,
            'max_amount' => null,
            'rate_percentage' => 10,
            'effective_year' => 2026,
        ]);
        $start = Carbon::create(2026, 9, 1);
        $end = Carbon::create(2026, 9, 30);

        foreach ($employees as $emp) {

            $date = $start->copy();

            while ($date->lte($end)) {

                if ($date->isWeekday()) {

                    Attendance::factory()->create([
                        'employee_id' => $emp->id,
                        'attendance_date' => $date->format('Y-m-d'),
                    ]);
                }

                $date->addDay();
            }

            for ($day = 3; $day <= 30; $day += 3) {
        $date = Carbon::create(2026, 9, $day)->toDateString();

        $attendance = $emp->attendances
            ->firstWhere('attendance_date', $date);

        if (!$attendance || $attendance->status !== 'present') {
            continue;
        }

        Overtime::factory()->create([
            'employee_id'   => $emp->id,
            'attendance_id' => $attendance->id,
            'date' => $date,
            'from_time'     => '18:00:00',
            'to_time'       => '20:00:00',
            'reason'        => fake()->sentence(),
            'status'        => 'pending',
        ]);
    }
        }
    }
}
