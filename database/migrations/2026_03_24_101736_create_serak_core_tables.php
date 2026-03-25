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

    Schema::create('departments', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('shifts', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->time('start_time');
        $table->time('end_time');
        $table->timestamps();
    });


    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('department_id')->constrained(); 
        $table->foreignId('shift_id')->nullable()->constrained(); 
        $table->integer('fingerprint_device_id')->unique()->nullable();
        $table->string('nip')->unique();
        $table->string('name');
        $table->enum('type', ['Tetap', 'Harian Lepas']);
        $table->enum('status', ['Aktif', 'Resign', 'PHK'])->default('Aktif');
        $table->decimal('daily_salary', 15, 2)->default(0); 
        $table->decimal('base_salary', 15, 2)->default(0);  
        $table->decimal('overtime_rate', 15, 2)->default(0); 
        $table->date('joined_at');
        $table->date('resigned_at')->nullable();
        $table->timestamps();
    });

    
    Schema::create('employee_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['SP1', 'SP2', 'SP3', 'Mutasi', 'Kinerja', 'Resign']);
        $table->text('description');
        $table->date('event_date');
        $table->timestamps();
    });
}

 /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
