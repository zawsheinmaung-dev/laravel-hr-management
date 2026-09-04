<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => Branch::inRandomOrder()->value('id'),
            'name' => fake()->unique()->randomElement([
                'Human Resources',
                'Information Technology',
                'Finance',
                'Marketing',
                'Sales',
                'Administration',
                'Operations',
                'Customer Service',
            ]),
            'code'=>'DEP-'. fake()->unique()->numerify('###'),
            'parent_department_id'=>Department::inRandomOrder()->value('id'),
            'head_employee_id'=>null,
            'description'=>fake()->paragraphs(10,true)

        ];
    }
}
