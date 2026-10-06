<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    private const SHIFT_START = 9;
    private const SHIFT_END = 17;
    private const BREAK_MINUTES = 60;

    public function definition(): array
    {
        $lateMinutes = fake()->boolean(15)
            ? fake()->numberBetween(5, 60)
            : 0;

        $earlyLeaveMinutes = fake()->boolean(8)
            ? fake()->numberBetween(10, 90)
            : 0;

        $overtimeMinutes = ($earlyLeaveMinutes === 0 && fake()->boolean(15))
            ? fake()->numberBetween(30, 180)
            : 0;

        return [
            'employee_id' => Employee::query()
                ->inRandomOrder()
                ->value('id'),

            'attendance_date' => fake()
                ->dateTimeBetween('2026-10-01', '2026-10-31')
                ->format('Y-m-d'),

            'check_in' => fn (array $attrs) => Carbon::parse($attrs['attendance_date'])
                ->setTime(self::SHIFT_START, 0)
                ->addMinutes($lateMinutes)
                ->format('H:i:s'),

            'check_out' => fn (array $attrs) => Carbon::parse($attrs['attendance_date'])
                ->setTime(self::SHIFT_END, 0)
                ->subMinutes($earlyLeaveMinutes)
                ->addMinutes($overtimeMinutes)
                ->format('H:i:s'),

            'working_hours' => fn (array $attrs) => round(
                max(
                    0,
                    Carbon::parse($attrs['check_in'])
                        ->diffInMinutes(
                            Carbon::parse($attrs['check_out'])
                        ) - self::BREAK_MINUTES
                ) / 60,
                2
            ),

            'late_minutes' => $lateMinutes,

            'early_leave_minutes' => $earlyLeaveMinutes,

            'overtime_minutes' => $overtimeMinutes,

            'status' => $lateMinutes > 0 ? 'late' : 'present',
        ];
    }
}