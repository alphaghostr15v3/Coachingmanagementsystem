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
        Schema::connection('tenant')->table('salary_slips', function (Blueprint $table) {
            $table->integer('total_days')->default(0)->after('basic_salary');
            $table->decimal('per_day_pay', 10, 2)->default(0)->after('total_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('salary_slips', function (Blueprint $table) {
            $table->dropColumn(['total_days', 'per_day_pay']);
        });
    }
};
