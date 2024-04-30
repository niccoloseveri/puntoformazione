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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->date('data_nascita')->after('cf')->nullable();
            $table->string('paese_nascita')->after('data_nascita')->nullable();
            $table->string('luogo_nascita')->after('paese_nascita')->nullable();
            $table->string('prov_nascita')->after('luogo_nascita')->nullable();
            $table->string('prov')->after('cap')->nullable();
            $table->string('paese_residenza')->after('prov')->nullable();
            $table->string('cittadinanza')->after('prov_nascita')->nullable();
            $table->string('titolo_studio')->after('cittadinanza')->nullable();
            $table->string('genere')->after('titolo_studio')->nullable();
            $table->text('note')->after('genere')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
