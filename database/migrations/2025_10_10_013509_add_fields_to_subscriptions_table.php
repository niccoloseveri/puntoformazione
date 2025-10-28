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
            if (!Schema::hasColumn('subscriptions','installments_mode')) {
                $table->string('installments_mode')->default('by_amount')->after('start_date'); // 'by_amount' | 'by_count'
            }
            if (!Schema::hasColumn('subscriptions','installments_count')) {
                $table->unsignedInteger('installments_count')->nullable()->after('installments_mode');
            }
            $table->bigInteger('down_payment')->default(0)->nullable()->after('installments_count');   // centesimi
            $table->unsignedTinyInteger('pay_day_of_month')->nullable()->after('down_payment'); // 1..31

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
