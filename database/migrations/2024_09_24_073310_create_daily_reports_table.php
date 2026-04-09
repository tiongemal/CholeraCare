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
            Schema::create('daily_reports', function (Blueprint $table) {
                $table->id('report_id');
                $table->unsignedBigInteger('field_worker_id');
                $table->unsignedBigInteger('location_id');
                $table->date('report_date');
                $table->integer('suspected_cases');
                $table->integer('confirmed_cases');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();

                $table->foreign('field_worker_id')->references('user_id')->on('users')->onDelete('cascade');
                $table->foreign('location_id')->references('location_id')->on('location')->onDelete('cascade');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
