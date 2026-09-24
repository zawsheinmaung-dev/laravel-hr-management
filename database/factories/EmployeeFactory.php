<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Employees;
use App\Models\Position;
use App\Models\SalaryStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employees>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'user_id' => null,

    'employee_code' => 'EMP-' . fake()->unique()->numerify('####'),

    'first_name' => fake()->firstName(),
    'last_name' => fake()->lastName(),

    'gender' => fake()->randomElement([
        'male',
        'female',
        'other',
    ]),

    'dob' => fake()
        ->dateTimeBetween('-50 years', '-20 years')
        ->format('Y-m-d'),

    'national_id' => fake()->unique()->numerify('############'),

    'phone' => fake()->phoneNumber(),
    'address' => fake()->address(),

    'department_id' => Department::inRandomOrder()->value('id'),
    'position_id' => Position::inRandomOrder()->value('id'),

    'manager_id' => null,

    'salary_structure_id' => null,

    'basic_salary' => fake()->randomFloat(2, 500, 2000),

    'join_date' => fake()
        ->dateTimeBetween('-5 years', 'now')
        ->format('Y-m-d'),

    'resign_date' => null,

    'employment_type' => fake()->randomElement([
        'full_time',
        'part_time',
        'contract',
        'intern',
    ]),

    'employment_status' => fake()->randomElement([
        'permanent',
        'probation',
    ]),

    'profile_photo' => null,
];
    }
}
