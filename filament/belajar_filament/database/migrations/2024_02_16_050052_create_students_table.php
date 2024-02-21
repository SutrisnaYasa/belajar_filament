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
        // Schema::create('students', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nim')->unique();
        //     $table->string('nama');
        //     $table->enum('fakultas', ['FTID', 'FEB']);
        //     $table->timestamps();
        // });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->nullable();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->string('birthday')->nullable();
            $table->enum('religion', ['Hindu', 'Islam'])->default('Hindu');
            $table->string('contact')->nullable();
            $table->string('profile')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
