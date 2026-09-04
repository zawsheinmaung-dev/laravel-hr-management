<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->unique()->city().'Branch',
            'code'=>'RB-'. fake()->unique()->numerify('###'),
            'phone'=>fake()->phoneNumber(),
            'address'=>fake()->address(),
            'manager_id'=>Employee::inRandomOrder()->value('id')
        ];
    }
}
