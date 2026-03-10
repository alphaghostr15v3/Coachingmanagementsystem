<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            // Store whether this was intra-state or inter-state transaction
            $table->string('gst_type')->nullable()->after('total_amount'); // 'intra' | 'inter'
            $table->string('student_state')->nullable()->after('gst_type');
            $table->string('institute_state')->nullable()->after('student_state');
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropColumn(['gst_type', 'student_state', 'institute_state']);
        });
    }
};
