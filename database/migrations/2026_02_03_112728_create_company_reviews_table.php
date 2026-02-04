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
        Schema::create('company_reviews', function (Blueprint $table) {
            $table->id('review_id');

            // ===== Foreign keys =====
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('moderated_by')->nullable();

            // ===== Ratings =====
            $table->decimal('overall_rating', 2, 1); // 1.0 - 5.0
            $table->unsignedTinyInteger('work_environment_rating')->nullable();
            $table->unsignedTinyInteger('salary_benefit_rating')->nullable();
            $table->unsignedTinyInteger('career_development_rating')->nullable();
            $table->unsignedTinyInteger('management_rating')->nullable();

            // ===== Review content =====
            $table->string('review_title', 255)->nullable();
            $table->text('review_text')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();

            // ===== Verification & employment =====
            $table->boolean('is_verified')->default(false);

            $table->enum('employment_status', [
                'current',
                'former',
                'intern'
            ])->nullable();

            $table->string('job_title', 100)->nullable();
            $table->integer('work_duration_months')->nullable();

            $table->boolean('is_anonymous')->default(false);

            // ===== Moderation =====
            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->timestamp('moderated_at')->nullable();

            // ===== Interaction =====
            $table->integer('helpful_count')->default(0);

            // ===== Timestamps =====
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();

            // ===== Indexes =====
            $table->index('subscription_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('overall_rating');

            // ===== Constraints =====
            $table->foreign('subscription_id')
                ->references('subscription_id')
                ->on('recruiter_subscriptions')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('moderated_by')
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
        Schema::dropIfExists('company_reviews');
    }
};
