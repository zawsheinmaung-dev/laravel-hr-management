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
    private const SHIFT_START = 9;   // 09:00
    private const SHIFT_END   = 17;  // 17:00
    private const BREAK_MINUTES = 60;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lateMinutes = fake()->boolean(15) ? fake()->numberBetween(5, 60) : 0;
        $earlyLeaveMinutes = fake()->boolean(8) ? fake()->numberBetween(10, 90) : 0;

        // စောပြန်တဲ့နေ့မှာ OT မရှိစေရန်
        $overtimeMinutes = ($earlyLeaveMinutes === 0 && fake()->boolean(15))
            ? fake()->numberBetween(30, 180)
            : 0;

        return [
            // Employee ရှိပြီးသားထဲက random တစ်ယောက်၊ မရှိသေးရင် factory နဲ့ အသစ်ဆောက်
            'employee_id' => Employee::query()->inRandomOrder()->value('id')
                ?? Employee::factory(),

            'attendance_date' => fake()->dateTimeBetween('-30 days', '-1 day')->format('Y-m-d'),

            // attendance_date ကို override လုပ်လည်း အချိန်တွေ လိုက်ကိုက်အောင် closure သုံးထားတယ်
            'check_in' => fn (array $attrs) => Carbon::parse($attrs['attendance_date'])
                ->setTime(self::SHIFT_START, 0)
                ->addMinutes($lateMinutes)
                ->format('H:i:s'),

            'check_out' => fn (array $attrs) => Carbon::parse($attrs['attendance_date'])
                ->setTime(self::SHIFT_END, 0)
                ->subMinutes($earlyLeaveMinutes)
                ->addMinutes($overtimeMinutes)
                ->format('H:i:s'),

            // နာရီ (decimal)၊ ထမင်းစားချိန် 1 နာရီ နုတ်ပြီး
            'working_hours' => fn (array $attrs) => round(
                max(0, Carbon::parse($attrs['check_in'])->diffInMinutes(Carbon::parse($attrs['check_out'])) - self::BREAK_MINUTES) / 60,
                2
            ),

            'late_minutes'        => $lateMinutes,
            'early_leave_minutes' => $earlyLeaveMinutes,
            'overtime_minutes'    => $overtimeMinutes,
        ];
    }
}