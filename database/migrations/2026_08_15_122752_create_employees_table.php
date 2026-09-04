<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // User account
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Employee identification
            $table->string('employee_code')->unique()->nullable();

            // Personal information
            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->enum('gender', [
                'male',
                'female',
                'other',
            ])->nullable();

            $table->date('dob')->nullable();

            $table->string('national_id')
                ->nullable()
                ->unique();

            $table->string('phone')->nullable();
            $table->string('personal_email')->nullable();
            $table->text('address')->nullable();

            // Organization
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('position_id')
                ->nullable()
                ->constrained('positions')
                ->nullOnDelete();

            // Employee manager
            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            // Salary
            $table->foreignId('salary_structure_id')
                ->nullable()
                ->constrained('salary_structures')
                ->nullOnDelete();

            $table->decimal('basic_salary', 12, 2)
                ->default(0);

            // Employment
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();

            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'contract',
                'intern',
            ])->default('full_time');

            $table->enum('employment_status', [
                'permanent',
                'probation',
                'resigned',
                'terminated',
            ])->default('probation');

            // Profile
            $table->string('profile_photo')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};