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
        Schema::create('payments_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payments_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('installments_id')->constrained('installments')->cascadeOnDelete();
            $table->bigInteger('amount_applied');
            $table->timestamps();

            $table->index(['payments_id']);
            $table->index(['installments_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_installments');
    }
};
