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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');

            $table->unsignedBigInteger('subscription_id');

            $table->string('transaction_code', 100)->unique();

            $table->string('payment_method', 50);

            $table->decimal('amount', 10, 2);

            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'refunded'
            ])->default('pending');

            $table->json('gateway_response')->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Foreign key
            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('recruiter_subscriptions')
                ->onDelete('cascade');

            // Index tối ưu
            $table->index('subscription_id');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
