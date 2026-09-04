<?php

namespace Database\Factories;

use App\Models\Leavetype;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leavetype>
 */
class LeavetypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            [
                'name' => 'ANNUAL',
                'days_allowed_per_year' => 10,
                'is_paid' => true,
            ],
            [
                'name' => 'SICK',
                'days_allowed_per_year' => 30,
                'is_paid' => true,
            ],
            [
                'name' => 'CASUAL',
                'days_allowed_per_year' => 6,
                'is_paid' => true,
            ],
            [
                'name' => 'UNPAID',
                'days_allowed_per_year' => 0,
                'is_paid' => false,
            ],
        ];

        return [fake()->randomElement($types)];
    }
}
