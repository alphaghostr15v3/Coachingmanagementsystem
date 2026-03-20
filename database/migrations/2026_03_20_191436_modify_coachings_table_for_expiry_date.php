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
            $table->date('expiry_date')->nullable()->after('subscription_plan');
            $table->dropColumn('subscription_tier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coachings', function (Blueprint $table) {
            $table->string('subscription_tier')->nullable()->after('subscription_plan');
            $table->dropColumn('expiry_date');
        });
    }
};
