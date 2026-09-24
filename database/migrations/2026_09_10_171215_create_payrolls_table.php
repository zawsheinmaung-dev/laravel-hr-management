<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_batch_id')->constrained('payroll_batches');
            $table->foreignId('employee_id')->constrained('employees');
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('total_allowance', 15, 2);
            $table->decimal('total_bonus', 15, 2);
            $table->decimal('total_deduction', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('net_salary', 15, 2);
            $table->enum('status', [
                'generated',
                'approved',
                'paid',
            ]);
            $table->dateTime('generated_at');
            $table->unique([
                'payroll_batch_id',
                'employee_id',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
