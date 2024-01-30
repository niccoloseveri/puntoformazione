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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cf')->unique()->nullable();
            $table->string('via')->nullable();
            $table->string('citta')->nullable();
            $table->string('cap')->nullable();
            $table->string('tel')->nullable();
            $table->boolean('is_teacher')->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->string('full_name')->virtualAs('concat(name, \' \', surname)')->nullable();
            $table->string('address')->virtualAs('concat(via, \' \',cap, \' \', citta)')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
