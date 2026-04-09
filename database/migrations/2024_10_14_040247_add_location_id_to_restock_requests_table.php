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
        Schema::table('restock_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('quantity_left'); // Adjust the position if needed

            // If you have a locations table, you can create a foreign key constraint
            $table->foreign('location_id')->references('location_id')->on('location')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restock_requests', function (Blueprint $table) {
            $table->dropForeign(['location_id']); // If you added a foreign key
            $table->dropColumn('location_id');
        });
    }
};
