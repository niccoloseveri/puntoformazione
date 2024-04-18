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
            $table->foreignId('payment_options_id')->after('classrooms_id');
            $table->date('start_date')->after('is_teacher');
            $table->date('next_payment')->after('start_date')->nullable();
            $table->foreignId('statuses_id')->after('start_date')->nullable();
            $table->boolean('printed_cont')->default(false)->after('next_payment');
            $table->boolean('printed_priv')->default(false)->after('printed_cont');
            $table->boolean('printed_whats')->default(false)->after('printed_priv');

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
