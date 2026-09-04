<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::inRandomOrder()->value('id'),
            'title' => fake()->randomElement([
                'Software Engineer',
                'Senior Software Engineer',
                'HR Officer',
                'HR Manager',
                'Accountant',
                'Finance Manager',
                'Marketing Officer',
                'Sales Executive',
                'Admin Officer',
                'Project Manager',
            ]),

            'level' => fake()->randomElement([
                'Junior',
                'Mid-Level',
                'Senior',
                'Manager',
                'Director',
            ]),
            'description' => fake()->paragraphs(3, true),
        ];
    }
}
