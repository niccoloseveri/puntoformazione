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
        Schema::table('subscriptions', function (Blueprint $table) {
            //
            $table->boolean('pagato?')->default(false)->after('is_active');
            $table->integer('tot_rate')->nullable()->after('pagato?');
            $table->integer('imp_rata')->nullable()->after('tot_rate');
            $table->integer('altro_importo')->nullable()->after('imp_rata');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
        });
    }
};
