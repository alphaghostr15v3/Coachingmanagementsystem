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
        Schema::table('fees', function (Blueprint $table) {
            $table->decimal('cgst_rate', 5, 2)->default(0)->after('amount');
            $table->decimal('cgst_amount', 10, 2)->default(0)->after('cgst_rate');
            $table->decimal('sgst_rate', 5, 2)->default(0)->after('cgst_amount');
            $table->decimal('sgst_amount', 10, 2)->default(0)->after('sgst_rate');
            $table->decimal('igst_rate', 5, 2)->default(0)->after('sgst_amount');
            $table->decimal('igst_amount', 10, 2)->default(0)->after('igst_rate');
            $table->decimal('total_amount', 10, 2)->default(0)->after('igst_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropColumn([
                'cgst_rate', 'cgst_amount',
                'sgst_rate', 'sgst_amount',
                'igst_rate', 'igst_amount',
                'total_amount'
            ]);
        });
    }
};
