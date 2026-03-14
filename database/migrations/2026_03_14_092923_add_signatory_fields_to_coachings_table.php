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
        Schema::table('coachings', function (Blueprint $table) {
            $table->string('authorized_signatory')->nullable();
            $table->string('signatory_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coachings', function (Blueprint $table) {
            $table->dropColumn(['authorized_signatory', 'signatory_image']);
        });
    }
};
