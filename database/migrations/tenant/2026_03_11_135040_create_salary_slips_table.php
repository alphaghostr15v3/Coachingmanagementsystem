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
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('month');
            $table->integer('year');
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->json('earnings')->nullable();
            $table->json('deductions')->nullable();
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->string('payment_status')->default('Paid');
            $table->date('payment_date');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};
