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
        Schema::create('formativeunits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modules_id');
            $table->foreignId('classrooms_id');
            $table->foreignId('courses_id');
            $table->foreignId('users_id');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formativeunits');
    }
};
