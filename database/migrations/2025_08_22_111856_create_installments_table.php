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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriptions_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('n_rata');
            $table->date('due_date')->index();
            $table->bigInteger('amount');
            $table->timestamp('paid_at')->nullable()->index();
            $table->timestamps();
            $table->unique(['subscriptions_id', 'n_rata']);
            $table->index(['subscriptions_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
