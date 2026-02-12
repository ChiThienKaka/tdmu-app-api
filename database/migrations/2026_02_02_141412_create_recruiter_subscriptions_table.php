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
        Schema::create('recruiter_subscriptions', function (Blueprint $table) {
            $table->id('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('company_id');
            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', [
                'pending', 'active', 'expired', 'cancelled'
            ])->default('pending');

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // Index
            $table->index('user_id');
            $table->index('package_id');
            $table->index('status');

            // FK
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('company_id')
                ->references('company_id')
                ->on('recruiter_companies')
                ->cascadeOnDelete();
            $table->foreign('package_id')
                ->references('package_id')
                ->on('recruiter_packages')
                ->cascadeOnDelete();

            $table->foreign('approved_by')
                ->references('user_id')
                ->on('users')
                ->nullOnDelete();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_subscriptions');
    }
};
