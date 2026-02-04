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
        Schema::create('recruiter_payments', function (Blueprint $table) {
            $table->id('payment_id');
             $table->unsignedBigInteger('subscription_id');

            $table->enum('payment_status', [
                'pending', 'completed', 'failed'
            ])->default('pending');

            $table->string('payment_method', 50)->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('payment_transaction_id', 100)->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Index
            $table->index('subscription_id');
            $table->index('payment_status');

            // FK
            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('recruiter_subscriptions')
                ->cascadeOnDelete();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_payments');
    }
};
