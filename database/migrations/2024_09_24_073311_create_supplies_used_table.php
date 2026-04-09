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
        Schema::create('supplies_used', function (Blueprint $table) {
            $table->id('supply_use_id');
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('supply_id');
            $table->integer('quantity_used');
            $table->timestamps();

            $table->foreign('report_id')->references('report_id')->on('daily_reports')->onDelete('cascade');
            $table->foreign('supply_id')->references('supply_id')->on('supplies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies_used');
    }
};
