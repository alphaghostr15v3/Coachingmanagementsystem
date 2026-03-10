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
        Schema::create('coachings', function (Blueprint $table) {
            $table->id();
            $table->string('coaching_name');
            $table->string('owner_name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('database_name')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('subscription_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coachings');
    }
};
