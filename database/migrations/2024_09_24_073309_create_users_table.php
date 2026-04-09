<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
      Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('fullname');
            $table->string('password');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'field_staff', 'hq_staff']);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->enum('status', ['active', 'inactive'])->default('active');


            $table->foreign('location_id')->references('location_id')->on('location')->onDelete('set null');
        });
    }

    /*

        Reverse the migrations.

    */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
