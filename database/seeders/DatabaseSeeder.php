<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Employees;
use App\Models\Leavetype;
use App\Models\Position;
use App\Models\User;
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
        $this->call([RolePermissionSeeder::class]);

        User::factory(50)->create()->each(function ($user) {
            $role = Role::inRandomOrder()->first();
            $user->assignRole($role);
        });

        Branch::factory(5)->create();
        Department::factory(5)->create();
        Position::factory(10)->create();


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

        // LeaveType::create([
        //     'name' => 'ANNUAL',
        //     'days_allowed_per_year' => 10,
        //     'is_paid' => true,
        // ]);

        // LeaveType::create([
        //     'name' => 'SICK',
        //     'days_allowed_per_year' => 30,
        //     'is_paid' => true,
        // ]);

        // LeaveType::create([
        //     'name' => 'CASUAL',
        //     'days_allowed_per_year' => 6,
        //     'is_paid' => true,
        // ]);

        // LeaveType::create([
        //     'name' => 'UNPAID',
        //     'days_allowed_per_year' => 0,
        //     'is_paid' => false,
        // ]);

    }
}
