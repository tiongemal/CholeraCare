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
        Schema::table('cases', function (Blueprint $table) {
            $table->unsignedBigInteger('report_id')->nullable(); // Adjust based on your requirements

            // Optionally, you can add a foreign key constraint
            $table->foreign('report_id')->references('report_id')->on('daily_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['report_id']); // Drop the foreign key if it exists
            $table->dropColumn('report_id'); // Remove the column
        });
    }
};
