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
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cf')->unique();
            $table->string('via');
            $table->string('citta');
            $table->string('cap');
            $table->string('tel');
            $table->boolean('is_teacher')->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->string('full_name')->virtualAs('concat(name, \' \', surname)');
            $table->string('address')->virtualAs('concat(via, \' \',cap, \' \', citta)');
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
